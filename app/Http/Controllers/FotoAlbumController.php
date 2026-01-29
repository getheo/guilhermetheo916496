<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\FotoAlbum;
use App\Models\Artista;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;

class FotoAlbumController extends Controller
{
    /**
     * Upload de Arquivo
     *
     * @OA\POST(
     *     path="/api/foto-album",
     *     summary="Faz o upload de uma foto de album",
     *     tags={"Foto Upload"},
     *     @OA\Parameter(
     *         name="album_id",
     *         in="query",
     *         description="Nº de identificação do Album",
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
     *         description="Imagem do Album enviado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="file", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Erro no upload"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    
    public function upload(Request $request)
    {
        $album = Album::where('id', $request->album_id)->first();

        $request->validate([
            'album_id' => 'required|integer|exists:album,id',
            'file' => 'required|image|mimes:jpg,jpeg|max:10240',
        ]);

        if(!$album){
            return response()->json(['message' => 'Album não encontrado', 404]);
        }        
        
        $path = $request->file('file')->store('album/'.$request->album_id, 's3');
        //$path = Storage::disk('s3')->put('uploads/{$request->art_id}', $request->file('file'));
        
        $foto = FotoAlbum::create([
            'album_id' => $album->id,
            'fa_data' => Carbon::now(),
            'fa_bucket' => env('AWS_BUCKET'),
            'fa_hash' => $path,
            
        ]);
        return response()->json([
            'message' => 'Foto enviada com sucesso!',
            'foto_url' => $path,
        ]);

        return response()->json(['message' => 'Foto cadastrada com sucesso.', 'foto-album' => $foto, 200]);
    }    
}
