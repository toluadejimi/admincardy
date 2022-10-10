<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\View\ViewName;

class AuthController extends Controller
{


    public function login_now(Request $request){



            $api_key = env('ELASTIC_API');
            $from = env('FROM_API');

            $email_code = random_int(100000, 999999);

            $device = $request->header('User-Agent');
            $clientIP = request()->ip();

            $credentials = $request->validate([
                'email' => ['required', 'string'],
                'password' => ['required'],
            ]);



            if (Auth::attempt($credentials)) {



                if (Auth::user()->type == 1) {




                    $user = User::where("id", Auth::id())->get();



                    $email_code = User::where('id', Auth::id())
                        ->update(['email_code' => $email_code]);

                    $new_email_code = User::where('id', Auth::id())
                        ->first()->email_code;

                    $f_name = User::where('id', Auth::id())
                        ->first()->f_name;

                    $email = User::where('id', Auth::id())
                        ->first()->email;




                    $user_email = User::where('id', Auth::id())->first()->email;

                    require_once "vendor/autoload.php";
                    $client = new Client([
                        'base_uri' => 'https://api.elasticemail.com',
                    ]);

                    // The response to get
                    $res = $client->request('GET', '/v2/email/send', [
                        'query' => [

                            'apikey' => "$api_key",
                            'from' => "$from",
                            'fromName' => 'Cardy',
                            'sender' => "$from",
                            'senderName' => 'Cardy',
                            'subject' => 'Verification Code',
                            'to' => "$email",
                            'bodyHtml' => view('notification.verify-email', compact('new_email_code', 'f_name'))->render(),
                            'encodingType' => 0,

                        ]
                    ]);

                    $body = $res->getBody();
                    $array_body = json_decode($body);



                    return redirect('verify-email-code')->with('message', "Enter the verification code sent to $email");

                }return back()->with('error', 'You do not have business here');


            } else {
                return back()->with('error', 'Invalid Credentials');
            }




    }



    public function login_view(){


        return view('welcome');
    }


    public function verify_email_code_view(){


        return view('verify-email-code');
    }


    public function verify_email_code_now(Request $request){


        $email_code = User::where('id', Auth::user()->id)
        ->first()->email_code;


        $code = $request->code;

        if($email_code = $code){

            return redirect('admin-dashboard');
        }




        return back()->with('error', 'Invalid Code');





    }


}
