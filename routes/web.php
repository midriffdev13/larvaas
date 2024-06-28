<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Filament\Pages\Auth\PasswordReset\ResetPassword;
use app\Filament\App\Resources\ProfileSettingResource\Pages\EditProfileSetting;
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
    return view('welcome');
});

Route::get('/user/teams/invitations', function () {
    return view('welcome');
})->name('user.teams.invitations');

// Show password reset request form
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware('guest')->name('password.request');

// Handle password reset request
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with('status', trans($status))
                : back()->withErrors(['email' => trans($status)]);
})->middleware('guest')->name('password.email');

// Show password reset form
// Route::get('/admin/password-reset/reset', function (Request $request) {
//     $token = $request->query('token');
//     $email = $request->query('email');

//     return view('auth.passwords.reset', ['token' => $token, 'email' => $email]);
// })->middleware('guest')->name('password.reset');

Route::get('/admin/password-reset/reset', ResetPassword::class)->name('password.reset');
// Route::get('/app/profile-settings', EditProfileSetting::class)->name('profile.edit');


Route::get('profile', function () {
    // Uses 2FA middleware to protect the route
})->middleware('2fa');


// Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
