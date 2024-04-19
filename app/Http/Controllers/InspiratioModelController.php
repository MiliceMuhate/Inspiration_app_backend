<?php

namespace App\Http\Controllers;

use App\InspiratioModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class InspiratioModelController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191',
                'img' => 'required|mimes:jpeg,jpg,png',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()
                ], 422);
            } else {
                $path = 'imagens';
                // $img = $request->logo->getClientOriginalName();
                $img = Str::random(32) . "." . $request->img->getClientOriginalExtension();
                $request->img->move(public_path($path), $img);

                $empresa = InspiratioModel::create([
                    'name' => $request->name,
                    'path' => $path.'/'.$img,
                    'original_name' =>$img,
                ]);
                if ($empresa) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'publicacao criada com sucesso!'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Nao foi possivel criar publicacao!'
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            error_log('Error in Controller@store: ' . $e->getMessage());
            // Return Json Response with more specific error message
            return response()->json([
                'message' => 'An unexpected error occurred while creating the publication. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
public function index()
    {
        try {
            // Obtenha todos os registros da tabela usando o modelo InspiratioModel
            // Use `all()` para obter todos os registros
            $publicacoes = InspiratioModel::all();
    
            // Retorne os registros em uma resposta JSON
            return response()->json([
                'status' => 200,
                'data' => $publicacoes,
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            error_log('Error in Controller@index: ' . $e->getMessage());
            // Return Json Response with more specific error message
            return response()->json([
                'message' => 'An unexpected error occurred while fetching the publications. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}


