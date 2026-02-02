<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Models\ArtistaAlbum;
use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    /**
    *  @OA\GET(
    *      path="/api/artista",
    *      summary="Todos os Artistas",
    *      description="Lista todos os Artistas com seus albuns",
    *      tags={"Artistas"},
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
        $artista = Artista::with(['albuns'])->orderBy('art_nome')->paginate(10);
        return response()->json($artista);
    }    
        
    /**
    *  @OA\GET(
    *      path="/api/artista/{id}",
    *      summary="Mostra um Artista",
    *      description="Pesquisa por um artista através do (id)",
    *      tags={"Artistas"},
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Nº de identificação do artista",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Artista Encontrado",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Pessoa não encontrada"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function show(string $id)
    {
        $artista = Artista::where('id', $id)->with(['albuns', 'foto'])->first();        

        if (!$artista) {
            //return response('Não encontrado', 404)->json();
            return response()->json(['message' => 'Artista não encontrado'], 404);
        }
        return response()->json(['message' => 'Artista encontrado','artista' => $artista]);
    }

    /**
    *  @OA\GET(
    *      path="/api/artistas/{pesquisa}",
    *      summary="Pesquisar um Artista",
    *      description="Pesquise pelo nome do artista",
    *      tags={"Artistas"},
    *     @OA\Parameter(
    *          name="pesquisa",
    *          in="path",
    *          required=true,
    *          description="Pesquise pelo nome do artista",
    *          @OA\Schema(type="string", example="Artista Exemplo")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Artista Encontrado",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Artista não encontrado"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function pesquisa(string $pesquisa)
    {
        // Limpar o input para evitar caracteres problemáticos
        $pesquisaSegura = str_replace(['%', '_'], ['\%', '\_'], $pesquisa);

        $artistaPesquisa = Artista::with(['albuns'])->where('art_nome', 'ILIKE', '%' . $pesquisaSegura . '%')->orderBy('art_nome')->get();

        if ($artistaPesquisa->isEmpty()) {            
            return response()->json(['message' => 'Artista pesquisado não foi encontrado'], 404);
        }
        return response()->json(['message' => 'Artista pesquisado encontrado','artista' => $artistaPesquisa]);
    }

    public function create()
    {
        //
    }
    
    /**
    *  @OA\POST(
    *      path="/api/artista",
    *      summary="Cadastra novo Artista",
    *      description="Registra um novo Artista",
    *      tags={"Artistas"},
    *     @OA\Parameter(
    *         name="art_nome",
    *         in="query",
    *         description="Nome",
    *         required=true,
    *      ),
    *     @OA\Parameter(
    *         name="art_descricao",
    *         in="query",
    *         description="Descrição",
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
    *          description="Artista não encontrado"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function store(Request $request)
    {
        $artista = Artista::where('art_nome', $request->art_nome)->first();  

        if (!$artista) {             

            $validadeData = $request->validate([            
                'art_nome' => 'required|string',
                'art_descricao' => 'required|string',
            ]);

            $artista = Artista::create([            
                'art_nome' => $validadeData['art_nome'],
                'art_descricao' => $validadeData['art_descricao'],
            ]);
            
            return response()->json(['message' => 'Artista cadastrado com sucesso.','artista' => $artista], 200);
        }

        return response()->json(['message' => 'Artista com esse nome já cadastrada.'], 404);
    }
    

    public function edit(Artista $artista)
    {
        //
    }
    
    
    /**
     * @OA\PUT(
     *     path="/api/artista/{id}",
     *     summary="Atualizar dados de um Artista",
     *     description="Editar os dados de um artista através do ID na URL",
     *     tags={"Artistas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do artista a ser atualizado",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"art_nome","art_descricao"},
     *             @OA\Property(property="art_nome", type="string", example="Nome do artista"),
     *             @OA\Property(property="art_descricao", type="string", example="Descrição do artista")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Artista atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Artista atualizado com sucesso"),
     *             @OA\Property(property="artista", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="art_nome", type="string", example="Nome do artista"),
     *                 @OA\Property(property="art_descricao", type="string", example="Descrição do artista")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Requisição inválida"),
     *     @OA\Response(response=404, description="Artista não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function update($id, Request $request)
    {

        $artista = Artista::where('id', $id)->first();  

        if (!$artista) {
            return response()->json(['message' => 'Artista não encontrado.'], 404);
        }

        $validadeData = $request->validate([            
            'art_nome' => 'required|string',
            'art_descricao' => 'required|string',
        ]);

        $artista->update($validadeData);
        $artista->refresh();

        return response()->json([
            'message' => 'Artista atualizado com sucesso',
            'artista' => $artista->toArray()
        ], 200);
    }

    /**
    *  @OA\DELETE(
    *      path="/api/artista/{id}",
    *      summary="Exclui um Artista",
    *      description="Exclui um artista através do (id)",
    *      tags={"Artistas"},
    *     @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID do artista",
    *          @OA\Schema(type="integer", example=1)
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="artista excluído com sucesso",
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
        $artista = Artista::where('id', $id)->first();  
        
        if (!$artista) {
            return response()->json(['message' => 'Artista não encontrado.'], 404);
        }

        $artista->delete();        
        return response()->json(['message' => 'Artista excluído com sucesso'], 200);
    }
}
