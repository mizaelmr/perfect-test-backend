<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\Client;


class ClientController extends Controller
{
    function index(){

        $data = Client::all();

        $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'listando.',
                'data' => $data,
            ];
            return response()->json($result);
    }
}
