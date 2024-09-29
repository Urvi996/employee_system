<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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
    return view('welcome');
});

Route::post('/submit-employee', [EmployeeController::class, 'store']);
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employee', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/ajax', [EmployeeController::class, 'ajaxEmployees'])->name('employees.ajax');
