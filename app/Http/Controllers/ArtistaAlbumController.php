<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Models\Album;
use App\Models\ArtistaAlbum;
use Illuminate\Http\Request;

class ArtistaAlbumController extends Controller
{
    /**
     * @OA\POST(
     * path="/api/artistaalbum",
     * summary="Cadastra vínculo de Artista com álbum",
     * tags={"Artistas Albuns"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"art_id", "alb_id"},
     * @OA\Property(property="art_id", type="integer", example=1),
     * @OA\Property(property="alb_id", type="integer", example=1)
     * )
     * ),
     * @OA\Response(response=201, description="Vínculo criado"),
     * @OA\Response(response=409, description="Vínculo já existente"),
     * @OA\Response(response=404, description="Artista ou Álbum não encontrado"),
     * security={{"bearerAuth":{}}}
     * )
     */
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

    /**
     * @OA\DELETE(
     * path="/api/artistaalbum/{id}",
     * summary="Remove um vínculo",
     * tags={"Artistas Albuns"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Removido"),
     * security={{"bearerAuth":{}}}
     * )
     */
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