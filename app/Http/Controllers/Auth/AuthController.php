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
use Illuminate\Support\Str;

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


    public function customer_register(Request $request){


        $data = $request->all();

        $str = $data['phone'];

        $phone = $str2 = substr($str, 3);

        $file_n = random_int(1000, 9999);


        if ($request->file('identification_url')) {

                $file = $request->file('identification_url');
                $filename = date('YmdHi') . $file_n;
                $file->move(public_path('/upload/verify'), $filename);

                $file_url = url('') . "/public/upload/verify/$filename";

            }




        $databody = array(

            "first_name" => $data['f_name'],
            "last_name" => $data['l_name'],
            "email" => $data['email'],
            "dob" => $data['dob'],
            "identification_number" => $data['bvn'],


            "phone" => array(
                "phone_country_code" => "+234",
                "phone_number" => $phone,

            ),


            "identity" => array(
                "type" => $data['identification_type'],
                "number" =>  $data['identification_number'],
                "image" => $file_url ?? null,
                "country" => "NG"
            ),


            "address" => array(
                "street" => $data['address_line1'],
                "city" => $data['city'],
                "state" => $data['state'],
                "country" => "NG",
                "postal_code" => "770835"

            ),


        );

        $api_key = env('API_KEY');


        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.maplerad.com/v1/customers/enroll');
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
                'content-Type: application/json',
                'accept: application/json',
                "Authorization: Bearer $api_key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);

        $id = $var->data->id ?? null;
        $message = $var->message;


        if($var->status == true){


            $data = User::where('email', $data['email'])
            ->update([

                'customer_id' => $id,
                'f_name' => $data['f_name'],
                'l_name' => $data['l_name'],
                'email' => $data['email'],
                'dob' => $data['dob'],
                'bvn' => $data['bvn'],
                'identification_url' => $file_url,
                'phone' => $data['phone'],
                'address_line1' => $data['address_line1'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'identification_type' => $data['identification_type'],
                'identification_number' =>  $data['identification_number'],
                'is_kyc_verified' => 1,


            ]);

        }

        if($var->status == false){


            $data = User::where('email', $data['email'])
            ->update([

                'f_name' => $data['f_name'],
                'l_name' => $data['l_name'],
                'email' => $data['email'],
                'dob' => $data['dob'],
                'bvn' => $data['bvn'],
                'identification_url' => $file_url,
                'phone' => $data['phone'],
                'address_line1' => $data['address_line1'],
                'city' => $data['city'],
                'state' => $data['state'],
                'identification_type' => $data['identification_type'],
                'identification_number' =>  $data['identification_number'],
                'is_kyc_verified' => 1,
            ]);

        }


        return back()->with('message', $message);


    }


    public function suspend_customer(Request $request){

        $data = $request->all();

        $user_id = $data['id'];

        $customer_id = User::where('id', $user_id)
        ->first()->customer_id;


        $databody = array(

            "blacklist" => true

        );

        $api_key = env('API_KEY');


        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.maplerad.com/v1/customers/$customer_id/active");
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
                'content-Type: application/json',
                'accept: application/json',
                "Authorization: Bearer $api_key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);


        $message = $var->message;

        if($var->status == true){


            $data = User::where('id', $user_id)
            ->update([
                'kyc_status' => 1,
            ]);

        }

        return back()->with('message', $message);



    }



    public function unsuspend_customer(Request $request){

        $data = $request->all();

        $user_id = $data['id'];

        $customer_id = User::where('id', $user_id)
        ->first()->customer_id;


        $databody = array(

            "blacklist" => false

        );

        $api_key = env('API_KEY');


        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.maplerad.com/v1/customers/$customer_id/active");
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
                'content-Type: application/json',
                'accept: application/json',
                "Authorization: Bearer $api_key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);


        $message = $var->message;

        if($var->status == true){


            $data = User::where('id', $user_id)
            ->update([
                'kyc_status' => 0,
            ]);

        }

        return back()->with('message', $message);



    }





}
