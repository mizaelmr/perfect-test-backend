<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Model\Product;
use Exception;


class ProductController extends Controller
{
    function index(Request $request){
        try {

            $data = Product::all();

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
                'message' => 'Erro ' . $e->getMessage() . '. Não foi possível executar esta ação.'
            ];
            return response()->json($result, 500);
        }
    }

    function store(Request $request){
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|max:255|min:3',
                'description' => 'required',
                'price' => 'required'
            ],
            [
                '*.required' => 'Campo obrigatório',
                '*.max' => 'Excedeu a quantidade de caracteres',
                '*.min' => 'Poucos caracteres',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            $product = new Product();
            $product->fill($data);
            $product->price = str_replace(',', '.', $product->price);
            $product->save();

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'Produto gravado com sucesso!',
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

    function edit($id){
        try {
            
            $data = Product::find($id);

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

            $data = Product::find($id);

            if(!$data) {
                 throw new Exception('Produto não encontrado.');
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|min:3',
                'description' => 'required',
                'price' => 'required'
            ],
            [
                '*.required' => 'Campo obrigatório',
                '*.max' => 'Excedeu a quantidade de caracteres',
                '*.min' => 'Poucos caracteres',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            $data->fill($request->all());
            $data->price = str_replace(',', '.', $data->price);
            $data->save();

            $result = [
                'status' => 'sucesso',
                'status_code' => 200,
                'message' => 'Success!',
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

    function destroy($id){
        try {

            $data = Product::find($id);

            if(!$data) {
                 throw new Exception('Produto não encontrado.');
            }

            $data->delete();

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
