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
        $album = Album::with(['artistaAlbum'])->paginate(10);
        return response()->json($album);
    }
    
        
    /**
    *  @OA\GET(
    *      path="/api/album/{alb_id}",
    *      summary="Mostra um Album",
    *      description="Pesquisa por um album através do (alb_id)",
    *      tags={"Albuns"},
    *     @OA\Parameter(
     *         name="alb_id",
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
    public function show(string $alb_id)
    {
        $album = Album::where('alb_id', $alb_id)->with(['artistaAlbum'])->first();        

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
    *         name="alb_nome",
    *         in="query",
    *         description="Nome",
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
        $album = Album::where('alb_nome', $request->alb_nome)->first();  

        if (!$album) {             

            $validadeData = $request->validate([            
                'alb_nome' => 'required|string',
            ]);

            $album = Album::create([            
                'alb_nome' => $validadeData['alb_nome'],
            ]);
            
            return response()->json(['message' => 'Album cadastrado com sucesso.','album' => $album], 200);
        }

        return response()->json(['message' => 'Album com esse nome já cadastrada.', 404]);
    }


    /**
    *  @OA\PUT(
    *      path="/api/album/{alb_id}",
    *      summary="Atualizar dados de um Album",
    *      description="Editar os dados de um album através do (alb_id)",
    *      tags={"Albuns"},
    *     @OA\Parameter(
     *         name="alb_id",
     *         in="path",
     *         required=true,
     *         description="Nº de identificação do album",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Dados do Album atualizado com sucesso.",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Erro ao atualizar a Album"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */   
    
    /**
     * @OA\PUT(
     *     path="/api/album/{alb_id}",
     *     summary="Atualizar dados de um Album",
     *     description="Editar os dados de um album através do (alb_id)",
     *     tags={"Albuns"},     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"alb_id", "alb_nome"},
     *             @OA\Property(property="alb_id", type="integer", example="1"),
     *             @OA\Property(property="alb_nome", type="string", example="Nome album"),     
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
     *     @OA\Response(response=400, description="Requisição inválida"),
     *     @OA\Response(response=404, description="Endereco não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function edit(Album $album)
    {
        //
    }


    public function update(Request $request, Album $album)
    {
        $validadeData = $request->validate([
            'alb_id' => 'required|integer',
            'alb_nome' => 'required|string',
        ]);

        $album->update($validadeData);

        return response()->json($album, 200);
    }

    /**
    *  @OA\DELETE(
    *      path="/api/album/{alb_id}",
    *      summary="Exclui um Album",
    *      description="Exclui um album através do (alb_id)",
    *      tags={"Albuns"},
    *     @OA\Parameter(
     *         name="alb_id",
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
