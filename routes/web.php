<?php

use App\Http\Controllers\Frontend\AppointmentCalenderController;
use App\Http\Controllers\Frontend\PrescribedDrugsStatisticsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Frontend\AppointmentController;
use \App\Http\Controllers\Frontend\PatientPrescriptionController;
use App\Http\Controllers\Frontend\DoctorController;
use \App\Http\Controllers\Frontend\PatientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});
//Doctor Routes:
Route::resource('/patients/{patient}/prescriptions', PatientPrescriptionController::class,['except' => ['edit', 'update']])->middleware(['role:doctor']);
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index')->middleware(['role:doctor']);
Route::get('users/{user}/patients', [App\Http\Controllers\Frontend\UserPatientController::class, 'index'])->name('user.patients.index')->middleware(['role:doctor']);


//Receptionist
Route::resource('/appointments', AppointmentController::class)->middleware(['role:receptionist']);

Route::get('appointments/calendar', [AppointmentCalenderController::class, 'index'])->middleware(['role:receptionist']);
Route::get('appointments/calendar/{doctor}', [AppointmentCalenderController::class, 'index'])->middleware(['role:receptionist']);
Route::post('appointments/calendar/action', [AppointmentCalenderController::class, 'action'])->middleware(['role:receptionist']);
Route::post('/appointments/timeslots/{timeSlot}',[AppointmentController::class, 'store']);

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index')->middleware(['role:receptionist']);
//Prescribed drugs statistics
Route::get('/drugs', [PrescribedDrugsStatisticsController::class, 'index']);





Auth::routes();
