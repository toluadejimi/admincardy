<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\Rate;
use App\Mail\UnverifiedAccount;
use App\Models\Charge;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Authl;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Vcard;
use GuzzleHttp\Client;
use App\Mail\UsdCardDowntime;
use App\Mail\XmasAds;
use App\Mail\UsdCardActive;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\View\ViewName;
use DB;
use Mail;


class DashboardController extends Controller
{


    public function admin_dashboard()
    {

        $api_key = env('API_KEY');

        $users = User::all();

        $total_money_out = Transaction::where('transaction_type', 'cash_out')
            ->sum('debit');

        $total_money_in = Transaction::where('transaction_type', 'cash_in')
            ->sum('debit');

        $total_users = User::where('type', '2')
            ->count();


            // Mprate 

            $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $api_key",
            ];
            $client = new GuzzleClient([
                'headers' => $headers,
            ]);
            $body = '{
    
                }';
            $response = $client->request('POST', 'https://api.maplerad.com/v1/fx/quote', [
                'body' => json_encode([
                    'source_currency' => 'USD',
                    'target_currency' => 'NGN',
                    'amount' =>  10000
                ])
            ]);

            {
   
}
    
            $body = $response->getBody();
            $response = json_decode($body);


            $mp_rate = $response->data->rate;



        //get issuing ngn balance

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $api_key",
            ];
            $client = new GuzzleClient([
                'headers' => $headers,
            ]);
            $body = '{
    
                }';
            $response = $client->request('GET', 'https://api.maplerad.com/v1/wallets/NGN', [
                'body' => $body
            ]);

    
            $body = $response->getBody();
            $response = json_decode($body);


            $amount = $response->data->available_balance;

            $ngn_amount = $amount / 10000;


          //get issuing usd balance

          $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $api_key",
            ];
            $client = new GuzzleClient([
                'headers' => $headers,
            ]);
            $body = '{
    
                }';
            $response = $client->request('GET', 'https://api.maplerad.com/v1/wallets/USD', [
                'body' => $body
            ]);

    
            $body = $response->getBody();
            $response = json_decode($body);



            $amount = $response->data->available_balance;

            $usd_amount = $amount / 10000;


        $get_funding_wallet =  $cardy_rate = Charge::where('title', 'funding_wallet')
        ->first()->amount;



        $cardy_rate = Charge::where('title', 'rate')
        ->first()->amount;

        $get_creation_fee = Charge::where('title', 'usd_card_creation')
        ->first()->amount;

        $creation_fee = $cardy_rate * $get_creation_fee;


        $active_usd_cards = Vcard::where('card_type', 'usd')
        ->count();

       


       



        $transactions = Transaction::orderBy('id', 'DESC')
        ->paginate(10);

        $transactions_count = Transaction::all()->count();



        return view('admin-dashboard', compact('users','get_funding_wallet', 'usd_amount', 'ngn_amount', 'mp_rate','get_creation_fee','transactions_count', 'transactions','active_usd_cards', 'total_money_out', 'cardy_rate', 'creation_fee', 'total_users', 'total_money_in'));
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

        $vas = Transaction::orderBy('created_at', 'DESC')
        ->where('type', 'vas')
        ->paginate(100);

        $total = Transaction::orderBy('created_at', 'DESC')
        ->where('type', 'vas')
        ->sum('debit');


        return view('vas',compact('total_vas', 'total', 'vas'));





    }

    public function usd_downtime_email(Request $request){

        $users = User::select('*')
        ->orderBy('id','DESC')
        ->paginate(10);


        return view('usd-downtime', compact('users'));
    }

    public function usd_downtime(Request $request){


        $users = User::all();

        if ($users->count() > 0) {
            foreach($users as $key => $value){
                if (!empty($value->email)) {
                    $details = [
                      'subject' => 'Cardy USD Card Downtime',
                    ];

                    Mail::to($value->email)->send(new UsdCardDowntime($details));
                }
            }
        }

        return back()->with('message',"Email Sent Successfully");

    }


    public function usd_card_active(Request $request){


        $users = User::all();

        if ($users->count() > 0) {
            foreach($users as $key => $value){
                if (!empty($value->email)) {
                    $details = [
                      'subject' => 'USD CARD ACTIVE',
                    ];

                    Mail::to($value->email)->send(new UsdCardActive($details));
                }
            }
        }

        return back()->with('message',"Email Sent Successfully");

    }


    public function unverified_account(Request $request){


        $users = User::where('is_kyc_verified', 0)->get();

        if ($users->count() > 0) {
            foreach($users as $key => $value){
                if (!empty($value->email)) {
                    $details = [
                      'subject' => 'Cardy Account Verification',
                    ];

                    Mail::to($value->email)->send(new UnverifiedAccount($details));
                }
            }
        }

        return back()->with('message',"Email Sent Successfully");

    }


    public function rate(Request $request){

        $rates = Charge::where('title', 'rate' )
        ->first()->amount;

        $users = User::all();

        if ($users->count() > 0) {
            foreach($users as $key => $value){
                if (!empty($value->email)) {
                    $details = [
                      'subject' => 'Cardy Daily Rate',
                      'rate' => $rates,
                    ];

                    Mail::to($value->email)->send(new Rate($details));
                }
            }
        }

        return back()->with('message',"Email Sent Successfully");

    }


    public function xmasads(Request $request){


        $users = User::all();

        if ($users->count() > 0) {
            foreach($users as $key => $value){
                if (!empty($value->email)) {
                    $details = [
                      'subject' => 'December Online Shopping',
                    ];

                    Mail::to($value->email)->send(new XmasAds($details));
                }
            }
        }

        return back()->with('message',"Email Sent Successfully");

    }








}
