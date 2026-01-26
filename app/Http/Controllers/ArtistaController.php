<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    // Listar todos os artistas
    public function index()
    {
        $artistas = Artista::all();
        return response()->json(['message' => 'Artista index', 'data' => $artistas], 200);
    }

    // Mostrar um artista específico
    public function show($id)
    {
        $artista = Artista::find($id);
        if (!$artista) {
            return response()->json(['message' => 'Artista not found'], 404);
        }
        return response()->json(['message' => 'Artista show', 'data' => $artista], 200);
    }   

    // Criar um novo artista
    public function store(Request $request)
    {
        $artista = Artista::create($request->all());
        return response()->json(['message' => 'Artista criado', 'data' => $artista], 201);
    }

    // Atualizar um artista existente
    public function update(Request $request, $id)
    {
        $artista = Artista::find($id);
        if (!$artista) {
            return response()->json(['message' => 'Artista não encontrado'], 404);
        }
        $artista->update($request->all());
        return response()->json(['message' => 'Artista atualizado', 'data' => $artista], 200);
    }

    // Excluir um artista
    public function destroy($id)
    {
        $artista = Artista::find($id);
        if (!$artista) {
            return response()->json(['message' => 'Artista não encontrado'], 404);
        }
        $artista->delete();
        return response()->json(['message' => 'Artista excluído'], 200);
    }
}