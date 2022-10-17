<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManageController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardController;

use App\Http\Controllers\UserController;






Route::get('/', function () {
    return view('login');

});






//Auth

Route::get('welcome', [AuthController::class,'login_view']);


 Route::post('login-now', [AuthController::class,'login_now']);
 Route::get('verify-email-code', [AuthController::class,'verify_email_code_view']);

 Route::get('usd-card', [CardController::class,'vcard_view']);
 Route::get('card-info', [CardController::class,'card_info']);
 Route::get('delete-card', [CardController::class,'delete_card']);
 Route::get('liquidate-card', [CardController::class,'liquidate_card']);

















 Route::post('verify-email-code-now', [AuthController::class,'verify_email_code_now']);

Route::group(['middleware' => ['adminAuth']],function(){

//dashboard
Route::get('admin-dashboard', [DashboardController::class, 'admin_dashboard']);
Route::post('cardy-change-rate', [DashboardController::class, 'change_cardy_rate']);
Route::post('cardy-change-creation-rate', [DashboardController::class, 'change_cardy_creation_rate']);



//usrs
Route::get('users', [UserController::class,'user_view']);
Route::get('delete-user', [UserController::class,'delete_user']);

















//Transactions
Route::get('/fund-wallet', [TransactionController::class, 'fund_wallet_view']);
Route::post('cardy-change-rate', [DashboardController::class, 'change_cardy_rate']);
Route::post('cardy-change-creation-rate', [DashboardController::class, 'change_cardy_creation_rate']);
Route::post('fund-issuing-wallet-now', [TransactionController::class, 'fund_issuing_wallet_now']);




//virtual
Route::get('virtual', [DashboardController::class, 'virtual_view']);


});






