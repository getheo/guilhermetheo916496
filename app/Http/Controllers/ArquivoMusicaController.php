<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ArquivoMusica;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;

class ArquivoMusicaController extends Controller
{
    /**
     * Upload de Arquivo
     *
     * @OA\POST(
     *     path="/api/arquivo-musica",
     *     summary="Faz o upload de um arquivo de musica",
     *     tags={"Arquivo Musica MP3"},
     *     @OA\Parameter(
     *         name="album_id",
     *         in="query",
     *         description="Nº de identificação do Album",
     *         required=true
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
     *         description="Arquivo de música enviado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="file", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Erro no upload do MP3"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    
    public function upload(Request $request)
    {
        $request->validate([
            'album_id' => 'required|integer|exists:album,id',
            'file' => 'required|file|mimetypes:audio/mpeg|max:10240',
        ]);

        $album = Album::where('id', $request->album_id)->first();

        if(!$album){
            return response()->json(['message' => 'Album não encontrado'], 404);
        }        
        
        $path = $request->file('file')->store('musica/'.$request->album_id, 's3');
        //$path = Storage::disk('s3')->put('uploads/{$request->art_id}', $request->file('file'));
        
        $arquivo = ArquivoMusica::create([
            'album_id' => $album->id,
            'fa_data' => Carbon::now(),
            'fa_bucket' => env('AWS_BUCKET'),
            'fa_hash' => $path,
            
        ]);
        return response()->json([
            'message' => 'Arquivo de música enviado com sucesso!',
            'arquivo_url' => $path,
        ]);

        return response()->json(['message' => 'Arquivo de música cadastrado com sucesso.', 'arquivo-musica' => $arquivo], 200);
    }    
}
