<?php

namespace App\Http\Controllers;

use App\Models\Musica;
use App\Models\ArtistaAlbum;
use Illuminate\Http\Request;

class MusicaController extends Controller
{
    /**
    *  @OA\GET(
    *      path="/api/musica",
    *      summary="Todas as Musicas",
    *      description="Lista todas as Musicas",
    *      tags={"Musicas"},
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
        $musica = Musica::with(['album'])->orderBy('mus_titulo')->paginate(10);
        return response()->json($musica);
    }
    
        
    /**
    *  @OA\GET(
    *      path="/api/musica/{id}",
    *      summary="Mostra uma Musica",
    *      description="Pesquisa por uma musica através do (id)",
    *      tags={"Musicas"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Nº de identificação da musica",
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Musica Encontrada",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Musica não encontrada"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function show(string $id)
    {
        $musica = Musica::where('id', $id)->with(['album'])->first();

        if (!$musica) {
            //return response('Não encontrado', 404)->json();
            return response()->json(['message' => 'Musica não encontrada', 404]);
        }
        return response()->json(['message' => 'Musica encontrada','musica' => $musica]);
    }

    public function create()
    {
        //
    }
    
    /**
    *  @OA\POST(
    *      path="/api/musica",
    *      summary="Cadastra nova Musica",
    *      description="Registra uma nova Musica",
    *      tags={"Musicas"},
    *     @OA\Parameter(
    *         name="mus_titulo",
    *         in="query",
    *         description="Titulo da Musica",
    *         required=true,
    *      ),
    *     @OA\Parameter(
    *         name="album_id",
    *         in="path",
    *         required=true,
    *         description="Nº de identificação do Album",
    *         @OA\Schema(type="integer", example=1)
    *     ),    
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Musica não encontrada"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function store(Request $request)
    {
        $musica = Musica::where('mus_titulo', $request->mus_titulo)->first();  

        if (!$musica) {             

            $validadeData = $request->validate([            
                'mus_titulo' => 'required|string',
            ]);

            $musica = Musica::create([            
                'mus_titulo' => $validadeData['mus_titulo'],
            ]);
            
            return response()->json(['message' => 'Musica cadastrada com sucesso.','musica' => $musica], 200);
        }

        return response()->json(['message' => 'Musica com esse titulo já cadastrada.', 404]);
    }

    public function edit(Musica $musica)
    {
        //
    }
    
    /**
     * @OA\PUT(
     *     path="/api/musica/{id}",
     *     summary="Atualizar dados de uma Musica",
     *     description="Editar os dados de uma musica através do (id)",
     *     tags={"Musicas"},     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "album_id", "mus_titulo"},
     *             @OA\Property(property="id", type="integer", example="1"),
     *             @OA\Property(property="album_id", type="integer", example="1"),
     *             @OA\Property(property="mus_titulo", type="string", example="Nome musica"),     
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Musica atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Musica atualizado com sucesso"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Musica não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function update(Request $request, Musica $musica)
    {
        $validadeData = $request->validate([
            'id' => 'required|integer',
            'album_id' => 'required|integer',
            'mus_titulo' => 'required|string',
        ]);

        $musica->update($validadeData);

        return response()->json($musica, 200);
    }

    /**
    *  @OA\DELETE(
    *      path="/api/musica/{id}",
    *      summary="Exclui uma Musica",
    *      description="Exclui uma musica através do (id)",
    *      tags={"Musicas"},
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do musica",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="musica excluído com sucesso",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Não foi possível excluir a musica",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )    
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function destroy(Musica $musica)
    {
        $musica->delete();
        return response()->json(null, 204);
    }
}
