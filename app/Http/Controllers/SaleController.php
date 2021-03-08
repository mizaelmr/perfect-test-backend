<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use \App\Model\Product;
use \App\Model\Client;
use \App\Model\Sale;


class SaleController extends Controller
{
    function index(){
        try {

            $data = Sale::all();

            //relationship populate
            foreach ($data as  $value) {
                $value->client_id = $value->client->name;
                $value->product_id = $value->product->name;
            }

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'listando.',
                'data' => $data,
            ];
            return response()->json($result);
        } catch (\Exception $e) {
            $result = [
                'status' => 'Erro',
                'status_code' => 500,
                'message' => 'Erro ' . $e . '. Não foi possível executar esta ação.'
            ];
            return response()->json($result, 500);
        }
    }

    function store(Request $request){
        try {
            DB::beginTransaction();

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required',
                'cpf' => 'required',

                'product' => 'required',
                'date' => 'required',
                'quantity' => 'required',
                'discount' => 'required',
                'status' => 'required',
            ],
            [
                '*.required' => 'Campo obrigatório',
                '*.max' => 'Excedeu a quantidade de caracteres',
                '*.min' => 'Poucos caracteres',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }
            
            $client = new Client();
            $client->name = $data['name'];
            $client->cpf = $data['cpf'];
            $client->email = $data['email'];
            $client->save();

            $sale = new Sale();
            $sale->discount = str_replace(',', '.', $data['discount']);
            $sale->product_id = $data['product'];
            $sale->client_id = $client->id;
            $sale->dateSale = $data['date'];
            $sale->amount = $data['quantity'];
            $sale->status = $data['status'];

            $produtc = Product::find($sale->product_id);

            if(!$produtc) {
                 throw new Exception('Produto não encontrado.');
            }

            $sale->total = (($produtc->price * $sale->amount) - $sale->discount);

            $sale->save();
            DB::commit();

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'Venda realizada com sucesso!',
                'data' => $data,
            ];
            return response()->json($result);

        } catch (\Exception $e) {
            DB::rollBack();
            $result = [
                'status' => 'Erro',
                'status_code' => 500,
                'message' => 'Erro ' . $e->getMessage() . '. Não foi possível executar esta ação.'
            ];
            return response()->json($result, 500);
        }
    }

    function edit($id){
         try {
            
            $data = Sale::find($id);

            $data->client_id = $data->client->name;
            $data->product_id = $data->product->name;

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'Success!',
                'data' => $data,
            ];
            
            return response()->json($result);

        } catch (\Throwable $th) {
            $result = [
                'status' => 'Erro',
                'status_code' => 500,
                'message' => 'Erro ' . $e->getMessage() . '. Não foi possível executar esta ação.'
            ];
            return response()->json($result, 500);
        }
    }


    function update(Request $request, $id){
        try {

            $sale = Sale::find($id);

            if(!$sale) {
                 throw new Exception('Produto não encontrado.');
            }

           DB::beginTransaction();

            $data = $request->all();

            $validator = Validator::make($data, [
                'status' => 'required',
            ],
            [
                '*.required' => 'Campo obrigatório',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            $sale->status = $data['status'];
            $sale->save();

            DB::commit();

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'Venda atualizada com sucesso!',
                'data' => $data,
            ];
            return response()->json($result);

        } catch (\Exception $e) {
            $result = [
                'status' => 'Erro',
                'status_code' => 500,
                'message' => 'Erro ' . $e->getMessage() . '. Não foi possível executar esta ação.'
            ];
            return response()->json($result, 500);
        }
    }

    function resume(){
        try {

            $response = DB::select(DB::raw('select status, count(id) as count, sum(total) as sum from sales group by status'));
            return response()->json($response);

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'Produto deletado com sucesso.',
            ];
            return response()->json($result);

        } catch (\Exception $e) {
            $result = [
                'status' => 'Erro',
                'status_code' => 500,
                'message' => 'Erro ' . $e->getMessage() . '. Não foi possível executar esta ação.'
            ];
            return response()->json($result, 500);
        }

    }
}
