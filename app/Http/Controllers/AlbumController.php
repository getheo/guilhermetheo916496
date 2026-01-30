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
        $album = Album::where('id', $id)->with(['artista', 'foto'])->first();        

        if (!$album) {
            //return response('Não encontrado', 404)->json();
            return response()->json(['message' => 'Album não encontrado', 404]);
        }
        return response()->json(['message' => 'Album encontrado','album' => $album]);
    }

    /**
    *  @OA\GET(
    *      path="/api/album/{pesquisa}",
    *      summary="Pesquisa Album pelo título",
    *      description="Pesquisa por um album através do titulo",
    *      tags={"Albuns"},
    *     @OA\Parameter(
    *          name="pesquisa",
    *          in="path",
    *          required=true,
    *          description="Titulo de pesquisa do album",
    *          @OA\Schema(type="string", example="album")
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
    public function pesquisa(string $pesquisa)
    {
        // Limpar o input para evitar caracteres problemáticos
        $pesquisaSegura = str_replace(['%', '_'], ['\%', '\_'], $pesquisa);

        $albumPesquisa = Album::where('alb_titulo', 'ILIKE', '%' . $pesquisaSegura . '%')->orderBy('alb_titulo')->get();

        if ($albumPesquisa->isEmpty()) {
            //return response('Não encontrado', 404)->json();
            return response()->json(['message' => 'Nenhum album encontrado com o título pesquisado'], 404);
        }
        return response()->json(['message' => 'Album encontrado','album' => $albumPesquisa]);
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
                'artista_id' => 'required|integer|exists:artista,id',
                'alb_titulo' => 'required|string',
            ]);

            $album = Album::create([            
                'artista_id' => $validadeData['artista_id'],
                'alb_titulo' => $validadeData['alb_titulo'],
            ]);

            $artistaAlbum = ArtistaAlbum::firstOrCreate([
                'art_id' => $validadeData['artista_id'],
                'alb_id' => $album->id,
            ]);
            
            return response()->json(['message' => 'Album cadastrado e vinculado ao artista com sucesso.','album' => $album, 'artista_album' => $artistaAlbum], 200);
        }

        return response()->json(['message' => 'Album com esse nome já cadastrada.'], 404);
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
     *             @OA\Property(property="message", type="string", example="Album atualizado com sucesso"),
     *             @OA\Property(property="album", type="object",
     *             @OA\Property(property="artista_id", type="integer", example="1"),
     *             @OA\Property(property="alb_titulo", type="string", example="Nome Album"),
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

        return response()->json(['message' => 'Album atualizado com sucesso.', 'album' => $album], 200);
    }    

    /**
    *  @OA\DELETE(
    *      path="/api/album/{id}",
    *      summary="Exclui um Album",
    *      description="Exclui um album através do (id)",
    *      tags={"Albuns"},
    *     @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID do album",
    *          @OA\Schema(type="integer", example=1)
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="album excluído com sucesso",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Não foi possível excluir o album",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )    
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function destroy($id)
    {
        $album = Album::where('id', $id)->first();  
        
        if (!$album) {
            return response()->json(['message' => 'Album não encontrado.'], 404);
        }        

        $artistaAlbum = ArtistaAlbum::where('alb_id', $album->id)->delete();

        $album->delete();        
        return response()->json(['message' => 'Album excluído com sucesso', 'album' => $album, 'artista_album' => $artistaAlbum], 200);
    }
}
