<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('tickets', function (Blueprint $table) {
      $table->id();
      $table->string('ticket_no')->unique();
      $table->string('name');
      $table->string('email');
      $table->string('phone')->nullable();
      $table->string('subject');
      $table->text('message');
      $table->string('type'); // e.g., Inquiry, Complaint, Feedback
      $table->string('status_id')->default('1');  // e.g., Open=1, In Progress=0, Resolved=2, Closed=3
      $table->integer('admin_id')->nullable(); // To track which admin is handling the ticket
      $table->json('admin_notes')->nullable(); // To store notes added by admins
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tickets');
  }
};
