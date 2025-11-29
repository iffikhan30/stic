<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  use HasFactory;

  protected $fillable = [
    'ticket_no',
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'type',
    'status_id',
    'admin_id',
    'admin_notes',
  ];
}
