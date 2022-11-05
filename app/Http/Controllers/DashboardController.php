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


class DashboardController extends Controller
{


    public function admin_dashboard()
    {

        $mono_key = env('MONO_KEY');

        $users = User::all();

        $total_money_out = Transaction::where('transaction_type', 'cash_out')
            ->sum('debit');

        $total_money_in = Transaction::where('transaction_type', 'cash_in')
            ->sum('debit');

        $total_users = User::where('type', '2')
            ->count();


        //get mono rate
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers
        ]);
        $body = '{

        }';
        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/misc/rates/usd', [
            'body' => $body
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $rate = $result->data->rate;


        $get_funding_wallet =  $cardy_rate = Charge::where('title', 'funding_wallet')
        ->first()->amount;



        $cardy_rate = Charge::where('title', 'rate')
        ->first()->amount;

        $get_creation_fee = Charge::where('title', 'usd_card_creation')
        ->first()->amount;

        $creation_fee = $cardy_rate * $get_creation_fee;


        $active_usd_cards = Vcard::where('card_type', 'usd')
        ->count();

        //get issuing usd balance
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers
        ]);
        $body = '{

        }';
        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/wallets?currency=usd', [
            'body' => $body
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $get_balance = $result->data->balance;



        $usd_balance = $get_balance / 100 ;


        //get issuing NGN balance
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers
        ]);
        $body = '{

        }';
        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/wallets?currency=ngn', [
            'body' => $body
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $get_balance = $result->data->balance;

        $ngn_balance = $get_balance / 100;



        $transactions = Transaction::orderBy('id', 'DESC')
        ->paginate(10);

        $transactions_count = Transaction::all()->count();



        return view('admin-dashboard', compact('users','get_funding_wallet', 'get_creation_fee','ngn_balance','transactions_count', 'transactions','usd_balance','active_usd_cards', 'total_money_out', 'cardy_rate', 'creation_fee', 'total_users', 'total_money_in', 'rate'));
    }








    public function change_cardy_rate(Request $request){



        $new_rate = $request->rate;

        $update = Charge::where('title', 'rate')
        ->update(['amount'=>$new_rate ]);

        return back()->with('message', "Cardy Rate has been successfully changed to NGN $new_rate");

    }


    public function change_cardy_creation_rate(Request $request){

        $new_rate = $request->rate;

        $update = Charge::where('title', 'usd_card_creation')
        ->update(['amount' =>  $new_rate ]);

        return back()->with('message', "Creation Fee has been successfully changed to $new_rate USD");

    }


    public function change_funding_wallet(Request $request){

        $wallet = $request->funding_wallet;

        $update = Charge::where('title', 'funding_wallet')
        ->update(['amount' =>  $wallet ]);

        return back()->with('message', "Wallet has been successfully changed to $wallet");

    }




    public function virtual_view(){

        $mono_key = env('MONO_KEY');

        $cardy_rate = Charge::where('title', 'rate')
        ->first()->amount;


        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers
        ]);
        $body = '{

        }';
        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/wallets?currency=usd', [
            'body' => $body
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $get_balance = $result->data->balance;

        $usd_wallet = $get_balance / 100 ;

        $users = User::where('type', '2')
        ->count();





        return view('virtual',compact('cardy_rate', 'usd_wallet', 'users'));
    }


    public function vas_view(){

        $total_vas = Transaction::where('type', 'vas')
        ->sum('debit');

        $vas = Transaction::where('type', 'vas')
        ->get();


        return view('vas',compact('total_vas', 'vas'));





    }






}
