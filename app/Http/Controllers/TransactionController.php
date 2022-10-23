<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\BankTransfer;
use App\Models\Charge;
use App\Models\EMoney;
use App\Models\IssuingWallet;
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
use Illuminate\Support\Str;

class TransactionController extends Controller
{



    public function fund_wallet_view(){


        $total_transactions = IssuingWallet::all()->sum('amount');

        $transactions = IssuingWallet::orderBy('id', 'DESC')
        ->paginate(10);




        return view('fund-wallet', compact('total_transactions', 'transactions'));
    }


    public function fund_issuing_wallet_now(Request $request){



        $amount = $request->amount;

        $momo_amount = $amount * 100;
        $currency = "usd";

        $mono_key = env('MONO_KEY');


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


        $amount_usd = round(($amount / $rate), 2);





         //fund on mono rate

        $databody = array(
            "currency" => "ngn",
            "amount" => $momo_amount
        );

        $mono_api_key = env('MONO_KEY');
        $body = json_encode($databody);

        $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.withmono.com/issuing/v1/wallets/fund');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "mono-sec-key: $mono_api_key",
                )
            );
            // $final_results = curl_exec($curl);

        $var = curl_exec($curl);
        curl_close($curl);


        $var = json_decode($var);

        if($var->status == 'successful'){

        $save = new IssuingWallet();
        $save->amount = $amount;
        $save->trx_id = Str::random(6);
        $save->amount_usd = $amount_usd;
        $save->message = $var->message;
        $save->account_number = $var->data->account_number;
        $save->reference = $var->data->reference;
        $save->bank_name = $var->data->bank_name;
        $save->account_name = $var->data->account_name;
        $save->save();

        return back()->with('message', 'Wallet payment created successfully');



    }return back()->with('error', 'Sorry!! check the api request');


    }




    public function bank_transfer_view(){


        $bank_transfers = BankTransfer::orderBy('id', 'ASC')
        ->paginate(10);



        return view('bank-transfer',compact('bank_transfers'));

    }


    public function update_transfer(Request $request){

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $id = $request->query('id');
        $amount = $request->query('amount');


        $update = BankTransfer::where('id',$id)
        ->update(['status' => '1']);

        $user_id = BankTransfer::where('id',$id)
        ->first()->user_id;

        $user_amount = EMoney::where('user_id', $user_id)
        ->first()->current_balance;

        $user_email = User::where('id', $user_id)
        ->first()->email;

        $f_name = User::where('id', $user_id)
        ->first()->f_name;

        $updated_amount = $user_amount + $amount;

        $wallet_update = EMoney::where('user_id', $user_id)
        ->update(['current_balance' => $updated_amount ]);


                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Fund Wallet',
                        'to' => "$user_email",
                        'bodyHtml' => view('wallet-fund-nofication', compact('f_name', 'amount'))->render(),
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);




        return back()->with('message', 'Transaction Sucessfully Updated');

    }


    public function delete_transfer(Request $request){

        $id = $request->query('id');

        $update = BankTransfer::where('id',$id)
        ->delete();

        return back()->with('message', 'Transaction Sucessfully removed');

    }



    public function wallet_transactions(){

        $mono_key = env('MONO_KEY');


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
            $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/wallets/transactions', [
                'body' => $body
            ]);

            $body = $response->getBody();
            $result = json_decode($body);

            $transactions = $result->data;




            return view('wallet-transaction',compact('transactions'));









    }


    public function bank_transfer_request(){


        $transactions = BankTransfer::orderBy('id', 'DESC')
        ->paginate(10);


        return view('bank-transfer-request',compact('transactions'));


    }


    public function update_bank_transfer(Request $request){

        $trx_id = $request->query('id');

        $transactions = BankTransfer::where('id', $trx_id)
        ->update(['status'=> 1 ]);


        return back()->with('message', 'Transaction Updated Successfully');


    }


























}
