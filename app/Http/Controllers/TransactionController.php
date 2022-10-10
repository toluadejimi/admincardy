<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Charge;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Authl;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Vcard;
use GuzzleHttp\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\View\ViewName;
use DB;


class TransactionController extends Controller
{



    public function fund_wallet_view(){

        return view('fund-wallet');
    }




}
