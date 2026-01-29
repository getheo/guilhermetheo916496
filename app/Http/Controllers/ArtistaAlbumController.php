<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Models\Album;
use App\Models\ArtistaAlbum;
use Illuminate\Http\Request;

class ArtistaAlbumController extends Controller
{
        
    public function store(Request $request)
    {
        // 1. Validação de existência e tipo
        $validatedData = $request->validate([
            'art_id' => 'required|integer|exists:artista,id',
            'alb_id' => 'required|integer|exists:album,id',
        ]);

        // 2. Verifica se este vínculo específico já existe (evita duplicidade na pivot)
        $existeVinculo = ArtistaAlbum::where('art_id', $validatedData['art_id'])
            ->where('alb_id', $validatedData['alb_id'])
            ->first();

        if ($existeVinculo) {
            return response()->json([
                'message' => 'Este artista já está vinculado a este álbum.'
            ], 409); // Conflict
        }

        // 3. Criação do vínculo
        $artistaAlbum = ArtistaAlbum::create($validatedData);

        return response()->json([
            'message' => 'Vínculo de artista com álbum cadastrado com sucesso.',
            'artista-album' => $artistaAlbum
        ], 201);
    }

    
    public function destroy($id)
    {
        $vinculo = ArtistaAlbum::find($id);

        if (!$vinculo) {
            return response()->json(['message' => 'Vínculo não encontrado'], 404);
        }

        $vinculo->delete();
        return response()->json(['message' => 'Vínculo removido com sucesso'], 200);
    }
}