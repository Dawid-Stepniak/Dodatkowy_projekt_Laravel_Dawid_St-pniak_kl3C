<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\PDFController;


Route::view('/', 'pages.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::view('/add_worker','pages.add_worker');
Route::post('/worker_form',[WorkerController::class,'AddWorker']);

Route::view('/add_gate','pages.add_gate');
Route::post('/gate_form',[GateController::class,'AddGate']);

Route::view('/workers_array','pages.workers_array');
Route::post('/check_worker',[WorkerController::class,'CheckAuthDegree']);

Route::view('/gates_array','pages.gates_array');
Route::post('/check_gate',[GateController::class,'CheckAuthDegree']);

Route::view('/generate_access_card','pages.generate_access_card');

Route::post('/generate_pdf', [PDFController::class, 'GeneratePDF']);