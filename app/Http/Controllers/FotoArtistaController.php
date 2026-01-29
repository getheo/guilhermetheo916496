<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\FotoArtista;
use App\Models\Artista;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;

class FotoArtistaController extends Controller
{
    /**
     * Upload de Arquivo
     *
     * @OA\POST(
     *     path="/api/foto-artista",
     *     summary="Faz o upload de uma foto de artista",
     *     tags={"Foto Upload"},
     *     @OA\Parameter(
     *         name="artista_id",
     *         in="query",
     *         description="Nº de identificação do Artista",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Imagem do Artista enviado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="artista_id", type="integer"),
     *             @OA\Property(property="file", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Erro no upload"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    
    public function upload(Request $request)
    {
        $artista = Artista::where('id', $request->artista_id)->first();

        $request->validate([
            'artista_id' => 'required|integer|exists:artista,id',
            'file' => 'required|image|mimes:jpg,jpeg|max:10240',
        ]);

        if(!$artista){
            return response()->json(['message' => 'Artista não encontrado', 404]);
        }        
        
        $path = $request->file('file')->store('artista/'.$request->artista_id, 's3');
        //$path = Storage::disk('s3')->put('uploads/{$request->art_id}', $request->file('file'));
        
        $foto = FotoArtista::create([
            'artista_id' => $artista->id,
            'fa_data' => Carbon::now(),
            'fa_bucket' => env('AWS_BUCKET'),
            'fa_hash' => $path,
            
        ]);
        return response()->json([
            'message' => 'Foto enviada com sucesso!',
            'foto_url' => $path,
        ]);

        return response()->json(['message' => 'Foto Artista cadastrada com sucesso.', 'foto-artista' => $foto, 200]);
    }    
}
