<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
  protected $tableNames = [
    'tech_mysql' => 'Tech Support',
    'bill_mysql' => 'Billing Support',
    'product_mysql' => 'Product Support',
    'general_mysql' => 'General Inquiries',
    'feedback_mysql' => 'Feedback and Suggestions',
  ];

  public function index()
  {
    $departments = $this->tableNames;
    return view('content.homepage', [
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
      'status_id' => '1',
    ];
    try {
      // Insert into the chosen DB
      $ticketId = DB::connection($type)->table('tickets')->insertGetId($data);
      if ($ticketId) {
        $data = DB::connection($type)->table('tickets')->where('id', $ticketId)->first();
        return redirect()
          ->back()
          ->with('status', 'Ticket Successfully Submitted, Your Ticket Number is ' . $data->ticket_no);
      }
    } catch (\Exception $e) {
      return redirect()
        ->back()
        ->with('status', 'Created Failed Failed' . $e);
    }
  }
}
