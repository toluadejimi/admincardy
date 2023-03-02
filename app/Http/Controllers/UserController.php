<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EMoney;
use App\Models\User;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{

    public function user_view(Request $request)
    {


        $users = User::orderBy('id', 'DESC')
        ->paginate(10);


        return view('users',compact('users'));


    }


    public function user_wallet(Request $request)
    {

        $user = User::all();

       $wallet = EMoney::orderBy('id', 'DESC')
       ->paginate(10);


        return view('user-wallet',compact('wallet', 'user'));


    }


    public function delete_user(Request $request)
    {

        $id = $request->query('id');

        $users = User::where('id',$id)
        ->delete();



        return redirect('users')->with('message', 'Users Deleted Successfully');


    }



    public function get_user(Request $request){


        $id = $request->id;

        $f_name = User::where('id', $id)
        ->first()->f_name;
        $l_name = User::where('id', $id)
        ->first()->l_name;
        $email = User::where('id', $id)
        ->first()->email;
        $m_name = User::where('id', $id)
        ->first()->m_name;
        $phone = User::where('id', $id)
        ->first()->phone;
        $dob = User::where('id', $id)
        ->first()->dob;
        $type = User::where('id', $id)
        ->first()->type;
        $gender = User::where('id', $id)
        ->first()->gender;
        $identification_number = User::where('id', $id)
        ->first()->identification_number;
        $identification_type = User::where('id', $id)
        ->first()->identification_type;
        $address_line1 = User::where('id', $id)
        ->first()->address_line1;
        $city = User::where('id', $id)
        ->first()->city;
        $state = User::where('id', $id)
        ->first()->state;
        $lga = User::where('id', $id)
        ->first()->lga;
        $bvn = User::where('id', $id)
        ->first()->bvn;
        $identification_url = User::where('id', $id)
        ->first()->identification_url;



        return view('edituser', compact('f_name', 'l_name', 'email', 'm_name', 'phone', 'dob', 'type',  'gender', 'identification_number', 'identification_type',
          'address_line1', 'city', 'state',  'lga' , 'bvn', 'id' , 'identification_url' ));





    }







}
