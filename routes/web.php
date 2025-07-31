<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorEmailController;



Route::middleware('web')->group(function () {
    Route::get('/register', fn () => abort(404));
    Route::get('/forgot-password', fn () => abort(404));
    Route::get('/reset-password', fn () => abort(404));
    Route::get('/verify-email', fn () => abort(404));
});




Route::get('/', function () {
    return redirect()->route('login');
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
    Route::get('employment-create',[EmployeeController::class,'create'])->name('employees.create');
    Route::get('employment-show/{id}',[EmployeeController::class,'show'])->name('employees.show');
    Route::get('employment-edit/{id}',[EmployeeController::class,'edit'])->name('employees.edit');




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
    



    /// set reminder 
    Route::get('/reminders',[ReminderController::class,'index'])->name('reminders.dashboard');
    
    Route::get('/reminders/create',[ReminderController::class,'create'])->name('reminders.create');

    Route::get('/reminders/{id}',[ReminderController::class,'view'])->name('reminders.show');

    Route::get('/reminders/{id}/edit',[ReminderController::class,'edit'])->name('reminders.edit');
    Route::post('/reminders/{id}/complete',[ReminderController::class,'complete'])->name('reminders.complete');
    Route::post('/reminders/renew',[ReminderController::class,'renew'])->name('calendar.index');

    Route::post('/reminders/settings',[ReminderController::class,'show'])->name('reminders.settings');




    //// promotion 
    Route::get('promotion-index',[App\Http\Controllers\PromotionController::class,'index'])->name('promotion.index');
});


