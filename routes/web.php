<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorEmailController;
use App\Http\Controllers\OtpController;
use App\Services\OtpService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

Route::middleware('web')->group(function () {
    Route::get('/register', fn () => abort(404));
    Route::get('/forgot-password', fn () => abort(404));
    Route::get('/reset-password', fn () => abort(404));
    Route::get('/verify-email', fn () => abort(404));
});




Route::middleware('guest')->group(function () {
    // Login form
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // Handle login submission
    Route::post('/email', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';


       // $credentials = $request->only('email', 'password');

        $credentials = [
            $login_type => $request->input('email'),
            'password' => $request->input('password'),
        ];


        $remember = $request->boolean('remember');

        Log::info('Login attempt', ['email' =>$request->input('email')]);

        // Attempt authentication
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            Log::info('Authentication successful, starting OTP flow', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Regenerate session for security
            $request->session()->regenerate();

            // Store user before logout
            $userId = $user->id;
            $userModel = $user;

            // Immediately log out for OTP verification
            Auth::logout();

            // Clear any previous OTP verification
            Session::forget('otp_verified');

            // Store user info for OTP process
            Session::put('otp_user_id', $userId);
            Session::put('login_timestamp', now()->timestamp);

            // Generate and send OTP
            $otpService = app(OtpService::class);
            if ($otpService->generateAndSendOtp($userModel)) {
                Log::info('OTP sent successfully, redirecting to OTP page', ['user_id' => $userId]);
                
                return redirect()->route('otp.show')
                    ->with('success', 'Please check your email for the verification code.');
            } else {
                Log::error('Failed to send OTP', ['user_id' => $userId]);
                
                // Clean up session if OTP fails
                Session::forget(['otp_user_id', 'login_timestamp']);
                
                return back()->withErrors([
                    'email' => 'Failed to send verification code. Please try again.',
                ])->withInput($request->except('password'));
            }
        }

        Log::warning('Authentication failed', ['email' => $credentials['email']]);

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    });

    // OTP verification routes
    Route::get('/otp', [OtpController::class, 'show'])->name('otp.show');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
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



    Route::get('/reminders/setting',[ReminderController::class,'reminderSetting'])->name('reminders.index');

    Route::get('reminders/settings',[ReminderController::class,'show'])->name('reminders.indexs');

    

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


    // report section 

    Route::get('/reports',[ReportController::class,'index'])->name('reports.dashboard');

    //// promotion 
    Route::get('promotion-index',[App\Http\Controllers\PromotionController::class,'index'])->name('promotion.index');
});


