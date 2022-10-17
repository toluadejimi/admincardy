<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function vcard_view(Request $request)
    {

        $mono_key = env('MONO_KEY');
        $users = User::all();

        //get All USD CARDS
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers,
        ]);

        $body = '{
        }';

        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/cards', [
            'body' => $body,
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $usd_card = $result->data;

        return view('usd-card', compact('usd_card'));

    }

    public function card_info(Request $request)
    {

        $mono_key = env('MONO_KEY');

        $id = $request->query('id');

        //get All USD CARDS
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers,
        ]);

        $body = '{
        }';

        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/cards', [
            'body' => $body,
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $usd_card = $result->data;



        //get info
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers,
        ]);
        $body = '{

            }';
        $response = $client->request('GET', "https://api.withmono.com/issuing/v1/cards/$id", [
            'body' => $body,
        ]);

        $body = $response->getBody();
        $r = json_decode($body);


        $name_on_card = $r->data->name_on_card;

        $balance = $r->data->balance / 100;



        return view('usd-card', compact('usd_card', 'name_on_card', 'balance'));

    }

    public function delete_card(Request $request)

    {


        $mono_key = env('MONO_KEY');

        $id = $request->query('id');


        //get All USD CARDS
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers,
        ]);

        $body = '{
        }';

        $response = $client->request('GET', 'https://api.withmono.com/issuing/v1/cards', [
            'body' => $body,
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        $usd_card = $result->data;

        //delete card
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers,
        ]);
        $body = '{

            }';
        $response = $client->request('DELETE', "https://api.withmono.com/issuing/v1/cards/$id", [
            'body' => $body,
        ]);

        $body = $response->getBody();
        $response = json_decode($body);


        return redirect('usd-card')->with('message', 'Card Removed Successfully');

    }

    public function liquidate_card(Request $request)
    {



        $mono_key = env('MONO_KEY');

        $id = $request->query('id');

        //;oquidate Card card
        $headers = [
            'Content-Type' => 'application/json',
            'mono-sec-key' => "$mono_key",
        ];
        $client = new GuzzleClient([
            'headers' => $headers,
        ]);
        $body = '{

            }';
        $response = $client->request('PATCH', "https://api.withmono.com/issuing/v1/cards/$id/liquidate", [
            'body' => $body,
        ]);

        $body = $response->getBody();
        $response = json_decode($body);


        return redirect('usd-card')->with('message', 'Card Amount Liquidated Successfully');
    }

    //get All Info CARDS

}
