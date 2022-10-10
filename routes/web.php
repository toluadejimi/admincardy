<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManageController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;





Route::get('/', function () {
    return view('login');

});






//Auth

Route::get('welcome', [AuthController::class,'login_view']);


 Route::post('login-now', [AuthController::class,'login_now']);
 Route::get('verify-email-code', [AuthController::class,'verify_email_code_view']);

 Route::post('verify-email-code-now', [AuthController::class,'verify_email_code_now']);

Route::group(['middleware' => ['adminAuth']],function(){


Route::get('admin-dashboard', [DashboardController::class, 'admin_dashboard']);
Route::post('cardy-change-rate', [DashboardController::class, 'change_cardy_rate']);
Route::post('cardy-change-creation-rate', [DashboardController::class, 'change_cardy_creation_rate']);






//Transactions
Route::get('/fund-wallet', [TransactionController::class, 'fund_wallet_view']);
Route::post('cardy-change-rate', [DashboardController::class, 'change_cardy_rate']);
Route::post('cardy-change-creation-rate', [DashboardController::class, 'change_cardy_creation_rate']);


});





