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
        $artista = Artista::with(['artistaAlbum'])->paginate(10);
        return response()->json($artista);
    }
    
        
    /**
    *  @OA\GET(
    *      path="/api/artista/{art_id}",
    *      summary="Mostra um Artista",
    *      description="Pesquisa por um artista através do (art_id)",
    *      tags={"Artistas"},
    *     @OA\Parameter(
     *         name="art_id",
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
    public function show(string $art_id)
    {
        $artista = Artista::where('art_id', $art_id)->with(['artistaAlbum'])->first();        

        if (!$artista) {
            //return response('Não encontrado', 404)->json();
            return response()->json(['message' => 'Artista não encontrado', 404]);
        }
        return response()->json(['message' => 'Artista encontrado','artista' => $artista]);
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
            ]);

            $artista = Artista::create([            
                'art_nome' => $validadeData['art_nome'],
            ]);
            
            return response()->json(['message' => 'Artista cadastrado com sucesso.','artista' => $artista], 200);
        }

        return response()->json(['message' => 'Artista com esse nome já cadastrada.', 404]);
    }


    /**
    *  @OA\PUT(
    *      path="/api/artista/{art_id}",
    *      summary="Atualizar dados de um Artista",
    *      description="Editar os dados de um artista através do (art_id)",
    *      tags={"Artistas"},
    *     @OA\Parameter(
     *         name="art_id",
     *         in="path",
     *         required=true,
     *         description="Nº de identificação do artista",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Dados do Artista atualizado com sucesso.",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Erro ao atualizar a Artista"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */   
    
    /**
     * @OA\PUT(
     *     path="/api/artista/{art_id}",
     *     summary="Atualizar dados de um Artista",
     *     description="Editar os dados de um artista através do (art_id)",
     *     tags={"Artistas"},     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"art_id", "art_nome"},
     *             @OA\Property(property="art_id", type="integer", example="1"),
     *             @OA\Property(property="art_nome", type="string", example="Nome artista"),     
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Artista atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Endereço atualizado com sucesso"),
     *             @OA\Property(property="pessoa", type="object",
     *             @OA\Property(property="pes_id", type="integer", example="1"),
     *             @OA\Property(property="pes_nome", type="string", example="Nome Pessoa"),
     *             @OA\Property(property="pes_data_nascimento", type="string", example="2020-01-01"),
     *             @OA\Property(property="pes_sexo", type="string", example="M"),
     *             @OA\Property(property="pes_mae", type="string", example="Mae Pessoa"),
     *             @OA\Property(property="pes_pai", type="string", example="Pai Pessoa")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Requisição inválida"),
     *     @OA\Response(response=404, description="Endereco não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function edit(Artista $artista)
    {
        //
    }


    public function update(Request $request, Artista $artista)
    {
        $validadeData = $request->validate([
            'art_id' => 'required|integer',
            'art_nome' => 'required|string',
        ]);

        $artista->update($validadeData);

        return response()->json($artista, 200);
    }

    /**
    *  @OA\DELETE(
    *      path="/api/artista/{art_id}",
    *      summary="Exclui um Artista",
    *      description="Exclui um artista através do (art_id)",
    *      tags={"Artistas"},
    *     @OA\Parameter(
     *         name="art_id",
     *         in="path",
     *         required=true,
     *         description="ID do artista",
     *         @OA\Schema(type="integer", example=1)
     *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Artista excluído com sucesso",
    *          @OA\MediaType(
    *              mediaType="application/json",
    *          )
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Não foi possível excluir a pessoa"
    *      ),
    *      security={{"bearerAuth":{}}}
    *  )
    */
    public function destroy(Artista $artista)
    {
        $artista->delete();
        return response()->json(null, 204);
    }
}
