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
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('login');

});



Route::get('usd-downtime-mail', [DashboardController::class,'usd_downtime_email']);
Route::get('usd-downtime', [DashboardController::class, 'usd_downtime'])->name('send.mail');
Route::get('usd-card-active', [DashboardController::class, 'usd_card_active']);
Route::get('uverified-account', [DashboardController::class, 'unverified_account']);







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
Route::post('change-funding-wallet', [DashboardController::class, 'change_funding_wallet']);
Route::post('cardy-change-creation-rate', [DashboardController::class, 'change_cardy_creation_rate']);






//vAS
Route::get('vas', [DashboardController::class, 'vas_view']);







//usrs
Route::get('users', [UserController::class,'user_view']);
Route::get('delete-user', [UserController::class,'delete_user']);
Route::get('user-wallet', [UserController::class,'user_wallet']);




//bank-transfer

Route::get('bank-transfer', [TransactionController::class,'bank_transfer_view']);
 Route::get('update-transfer', [TransactionController::class,'update_transfer']);
 Route::get('delete-transfer', [TransactionController::class,'delete_transfer']);


 //wallet transaction
 Route::get('wallet-transaction', [TransactionController::class,'wallet_transactions']);


 //all-transactions
Route::get('all-transactions', [TransactionController::class,'all_transactions']);
Route::get('delete-transaction', [TransactionController::class,'delete_transaction']);




















//Transactions
Route::get('/fund-wallet', [TransactionController::class, 'fund_wallet_view']);
Route::post('cardy-change-rate', [DashboardController::class, 'change_cardy_rate']);
Route::post('cardy-change-creation-rate', [DashboardController::class, 'change_cardy_creation_rate']);
Route::post('fund-issuing-wallet-now', [TransactionController::class, 'fund_issuing_wallet_now']);
Route::post('liquidate-card', [TransactionController::class, 'liquidate_card']);





//virtual
Route::get('virtual', [DashboardController::class, 'virtual_view']);


});






