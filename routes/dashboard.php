<?php

use App\Http\Controllers\pages\DashboardController;
use App\Http\Controllers\pages\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
  if (auth('admin')->check()) {
    // If admin is logged in, redirect to dashboard
    return redirect()->route('dashboard.index');
  } else {
    // If admin is not logged in, redirect to login
    return redirect()->route('admin.login');
  }
});

Route::group([
  'prefix' => 'dashboard',
  'middleware' => ['auth:admin', 'verified']
], function () {
  // Default route for the dashboard
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

  // Group other dashboard routes
  Route::group([
    'as' => 'dashboard.',
  ], function () {
    Route::resource('/dashboard', DashboardController::class);

    //TICKETS
    Route::resource('/tickets', TicketController::class);
  });
});
