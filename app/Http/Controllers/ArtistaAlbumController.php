<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Models\ArtistaAlbum;
use Illuminate\Http\Request;

class ArtistaAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
    *  @OA\POST(
    *      path="/api/artistaalbum",
    *      summary="Cadastra vinculo de Artista com album",
    *      description="Registra o album de um artista",
    *      tags={"Artistas Albuns"},
    *     @OA\Parameter(
    *         name="art_id",
    *         in="query",
    *         description="Nº identificação do artista",
    *         required=true,
    *      ),
    *     @OA\Parameter(
    *         name="alb_id",
    *         in="query",
    *         description="Nº identificação do Album",
    *         required=true,  
    *      ),      
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Erro"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function store(Request $request)
    {
        $artista = Artista::where('art_id', $request->art_id)->first();

        if ($artista) {             

            $validadeData = $request->validate([            
                'art_id' => 'required|integer',
                'alb_id' => 'required|integer',
            ]);

            $artistaAlbum = ArtistaAlbum::create([            
                'art_id' => $validadeData['art_id'],
                'alb_id' => $validadeData['alb_id'],
            ]);
            
            return response()->json(['message' => 'Vinculo de artista com album cadastrada com sucesso.','artista-album' => $artistaAlbum], 200);
        }

        return response()->json(['message' => 'Vinculo de artista com album já cadastrado.', 404]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ArtistaAlbum $artistaAlbum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArtistaAlbum $artistaAlbum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArtistaAlbum $artistaAlbum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArtistaAlbum $artistaAlbum)
    {
        //
    }
}
