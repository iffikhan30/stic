<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketController extends Controller
{
  protected $tableNames = [
    'tech_mysql' => 'Tech Support',
    'bill_mysql' => 'Billing Support',
    'product_mysql' => 'Product Support',
    'general_mysql' => 'General Inquiries',
    'feedback_mysql' => 'Feedback and Suggestions',
  ];
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $tickets = collect();

    foreach ($this->tableNames as $connectionName => $label) {
      $rows = DB::connection($connectionName)->table('tickets')->get()->map(function ($r) use ($connectionName) {
        $r->db = $connectionName;
        return $r;
      });

      $tickets = $tickets->concat($rows);
    }
    $data = $tickets->sortByDesc('created_at')->values();
    return view(
      'content.ticket.list',
      [
        'data' => $data,
      ]
    );
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $departments = $this->tableNames;
    return view('content.ticket.add', [
      'departments' => $departments,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email',
      'subject' => 'required|string|max:255',
      'content' => 'required|string',
      'type' => 'required'
    ]);

    $ticketNumber = strtoupper('BT-' . Str::random(8));
    $type = $request->type;
    $connection = array_key_exists($type, $this->tableNames) ?? null;

    if (!$connection) {
      return back()->withErrors(['type' => 'Invalid ticket type selected.']);
    }

    $data = [
      'ticket_number' => $ticketNumber,
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'subject' => $request->subject,
      'message' => $request->content,
      'status' => '1',
    ];


    //dd($data);
    try {
      // Insert into the chosen DB
      $ticket = DB::connection($connection)->table('tickets')->insert($data);
      if ($ticket) {

        return redirect()
          ->route('dashboard.ticket.edit', $ticket['id'])
          ->with('status', 'Ticket Successfully Created');
      }
    } catch (\Exception $e) {
      return redirect()
        ->back()
        ->with('status', 'Created Failed Failed' . $e);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $data = DB::table($this->tableName . ' as c')
      ->select(
        'c.*',
        'u.name as username',
      )
      ->leftJoin('admins as u', 'u.id', '=', 'c.admin_id')
      ->where('c.id', $id)->first();
    return response()->json([
      'data' => $data,
    ], 200);
  }

  /**
   * @param $id
   */
  public function edit($id)
  {
    $data = Ticket::query()->where('id', $id)->first();

    return view('content.ticket.edit', [
      'data'  => $data,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $ticket)
  {

    $request->validate([
      'title' => 'required',
    ]);
    $data = [
      'title' => $request->title,
      'subtitle' => $request->subtitle,
      'slug' => $request->slug,
      'content' => $request->content,
      'menu_order' => $request->menu_order,
      'type' => $request->type,
      'admin_id' => Auth::user()->id,
      'status_id' => $request->status_id,
    ];
    try {
      $response = Ticket::where('id', $ticket)->update($data);
      if ($response) {

        return redirect()
          ->back()
          ->with('status', 'Successfully Updated');
      }
    } catch (\Exception $e) {
      return redirect()
        ->back()
        ->with('status', 'Update Failed' . $e);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Ticket $ticket)
  {
    $general = Ticket::where('id', $ticket->id)->update([
      'status_id' => 3
    ]);
  }
}
