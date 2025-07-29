<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorEmailController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');




    ////// employment routes

    Route::get('employment-index',[EmployeeController::class,'index'])->name('employment.index');
    Route::get('employment-create',[EmployeeController::class,'index'])->name('employees.create');
    Route::get('employment-show/{id}',[EmployeeController::class,'show'])->name('employees.show');
    Route::get('employment-edit/{id}',[EmployeeController::class,'index'])->name('employees.edit');




    //// manage contract now 
    Route::get('contract-index',[ContractController::class,'index'])->name('contract.index');
    Route::get('contract-create',[ContractController::class,'create'])->name('contracts.create');
    Route::get('contract-show/{id}',[ContractController::class,'show'])->name('contracts.show');
    Route::get('contract-edit/{id}',[ContractController::class,'show'])->name('contracts.edit');
    Route::get('contract-renewal/{id}',[ContractController::class,'renewal'])->name('contracts.renew');




    ///  tracking process 
Route::get('tracking-index',[TrackingController::class,'index'])->name('tracking.index');
    
    

// notification controller 
Route::get('/notificaton-index',[NotificationController::class,'index'])->name('notification.index');

    

// penalty routes

Route::get('penalty-index',[PenaltyController::class,'index'])->name('penalty.index');
    


// setting section 

Route::get('setting-index',[SettingController::class,'index'])->name('setting.index');
   

});


