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
        $regional = Regional::orderBy('nome')->paginate(10);
        return response()->json($regional);
    }
}
