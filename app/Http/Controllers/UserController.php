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


       $wallet = EMoney::all();


        return view('user-wallet',compact('wallet'));


    }


    public function delete_user(Request $request)
    {

        $id = $request->query('id');

        $users = User::where('id',$id)
        ->delete();



        return redirect('users')->with('message', 'Users Deleted Successfully');


    }







}
