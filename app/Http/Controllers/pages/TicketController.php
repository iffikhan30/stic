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
    $departments = $this->tableNames;

    $tickets = collect();

    foreach ($this->tableNames as $connectionName => $label) {
      $query = DB::connection($connectionName)
        ->table('tickets');

      // --- APPLY SEARCH FILTERS ---
      if ($request->sType) {
        // Only load tickets from a single department/db
        if ($request->sType !== $connectionName) {
          continue;
        }
      }

      if ($request->sEmail) {
        $query->where('email', 'LIKE', '%' . $request->sEmail . '%');
      }

      if ($request->sTicketno) {
        $query->where('ticket_no', 'LIKE', '%' . $request->sTicketno . '%');
      }

      if ($request->sStatus) {
        $query->where('status_id', '=', $request->sStatus);
      }

      // Fetch rows from this database
      $rows = $query->get()->map(function ($r) use ($connectionName) {
        $r->db = $connectionName;
        return $r;
      });

      $tickets = $tickets->concat($rows);
    }

    $data = $tickets->sortByDesc('created_at')->values();
    return view(
      'content.ticket.list',
      [
        'departments' => $departments,
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
      'ticket_no' => $ticketNumber,
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'subject' => $request->subject,
      'message' => $request->content,
      'status_id' => $request->status_id,
    ];
    //dd($type);
    //dd($data);
    try {
      // Insert into the chosen DB
      $ticketId = DB::connection($type)->table('tickets')->insertGetId($data);
      if ($ticketId) {

        return redirect()
          ->route('dashboard.tickets.index')
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
    $exc = explode('-', $id);
    $id = $exc[0];
    $db = $exc[1];
    $data = DB::connection($db)
      ->table('tickets')->where('id', $id)->first();
    return view('content.ticket.view', [
      'data'  => $data,
      'db' => $db
    ]);
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
    $exc = explode('-', $ticket);
    $id = $exc[0];
    $db = $exc[1];
    $data = [
      'status_id' => $request->status_id,
    ];
    try {
      $response = DB::connection($db)
        ->table('tickets')->where('id', $id)->update($data);
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
  public function destroy($id)
  {
    dd($id);
    $data = DB::table($db)
      ->select('*')
      ->where('id', $id)->update();
  }
}
