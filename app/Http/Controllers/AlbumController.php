<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ArtistaAlbum;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
    *  @OA\GET(
    *      path="/api/album",
    *      summary="Todos os Albuns",
    *      description="Lista todos os Albuns",
    *      tags={"Albuns"},
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Nº da página",
    *         required=false,
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function index()
    {
        $album = Album::with(['artista'])->paginate(10);
        return response()->json($album);
    }
    
        
    /**
    *  @OA\GET(
    *      path="/api/album/{id}",
    *      summary="Mostra um Album",
    *      description="Pesquisa por um album através do (id)",
    *      tags={"Albuns"},
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Nº de identificação do album",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Album Encontrado",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Album não encontrado"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function show(string $id)
    {
        $album = Album::where('id', $id)->with(['artista'])->first();        

        if (!$album) {
            //return response('Não encontrado', 404)->json();
            return response()->json(['message' => 'Album não encontrado', 404]);
        }
        return response()->json(['message' => 'Album encontrado','album' => $album]);
    }

    public function create()
    {
        //
    }
    
    /**
    *  @OA\POST(
    *      path="/api/album",
    *      summary="Cadastra novo Album",
    *      description="Registra um novo Album",
    *      tags={"Albuns"},
    *     @OA\Parameter(
    *         name="artista_id",
    *         in="query",
    *         description="ID do artista",
    *         required=true,
    *      ),
    *     @OA\Parameter(
    *         name="alb_titulo",
    *         in="query",
    *         description="Titulo",
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
    *          description="Album não encontrado"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function store(Request $request)
    {
        $album = Album::where('alb_titulo', $request->alb_titulo)->first();  

        if (!$album) {             

            $validadeData = $request->validate([            
                'alb_titulo' => 'required|string',
                'artista_id' => 'required|integer',
            ]);

            $album = Album::create([            
                'alb_titulo' => $validadeData['alb_titulo'],
                'artista_id' => $validadeData['artista_id'],
            ]);
            
            return response()->json(['message' => 'Album cadastrado e vinculado ao artista com sucesso.','album' => $album], 200);
        }

        return response()->json(['message' => 'Album com esse nome já cadastrada.', 404]);
    }

    public function edit(Album $album)
    {
        //
    }     
    
    /**
     * @OA\PUT(
     *     path="/api/album/{id}",
     *     summary="Atualizar dados de um Album",
     *     description="Editar os dados de um album através do (id)",
     *     tags={"Albuns"},     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"artista_id", "alb_titulo"},
     *             @OA\Property(property="artista_id", type="integer", example="1"),
     *             @OA\Property(property="alb_titulo", type="string", example="Titulo album"),     
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Album atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Albumn atualizado com sucesso")     
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Endereco não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function update(Request $request, Album $album)
    {
        $validadeData = $request->validate([
            'artista_id' => 'required|integer',
            'alb_titulo' => 'required|string',
        ]);

        $album->update($validadeData);

        return response()->json($album, 200);
    }

    /**
    *  @OA\DELETE(
    *      path="/api/album/{id}",
    *      summary="Exclui um Album",
    *      description="Exclui um album através do (id)",
    *      tags={"Albuns"},
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do album",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Album excluído com sucesso",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Não foi possível excluir o album"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function destroy(Album $album)
    {
        $album->delete();
        return response()->json(null, 204);
    }
}
