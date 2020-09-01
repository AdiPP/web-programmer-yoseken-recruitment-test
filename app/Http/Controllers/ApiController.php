<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function get_user_list(){

      $client = new Client();

      $request = $client->get(env('API_PATH').'/trade_list', [
        'headers' => [
          'X-Authorization-Token' => md5(env('API_KEY')),
          'X-Authorization-Time'  => time()
        ]
      ]);

      $res = json_decode($request->getBody());

      $traders = $res->data;

      // Rename key, status to active.
      $traders = collect($traders)->map(function ($data) {
                $data->active = $data->status;
                unset($data->status);
                return $data;
              });

      return view('test.trader',compact('res','traders'));
    }
}
