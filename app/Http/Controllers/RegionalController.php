<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    /**
    *  @OA\GET(
    *      path="/api/regional",
    *      summary="Todos as Unidades Regionais",
    *      description="Lista todos as Unidade Regionais",
    *      tags={"Regionais"},
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
        $regional = Regional::orderBy('nome')->orderBy('nome')->paginate(10);
        return response()->json($regional);
    }

    /**
    *  @OA\GET(
    *      path="/api/regional/{pesquisa}",
    *      summary="Pesquisa uma Regional pelo nome",
    *      description="Pesquisa por uma regional através do (pesquisa)",
    *      tags={"Regionais"},
    *      @OA\Parameter(
    *          name="pesquisa",
    *          in="path",
    *          required=true,
    *          description="Texto de pesquisa da regional",
    *          @OA\Schema(type="string", example="regional")
    *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Regional Encontrada",
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
    public function pesquisa(string $pesquisa)
    {
        $regional = Regional::where('nome', 'ILIKE', "%$pesquisa%")->orderBy('nome')->get();
        
        if ($regional->isEmpty()) {            
            return response()->json(['message' => 'Nenhuma regional encontrada com o nome pesquisado'], 404);
        }
        return response()->json(['message' => 'Regional encontrada','regional' => $regional]);
    }
}
