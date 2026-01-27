<?php

namespace App\Http\Controllers;

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
     *         name="art_id",
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
     *         description="Arquivo enviado com sucesso",
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
        $artista = Artista::where('art_id', $request->art_id)->first();

        $request->validate([
            'art_id' => 'required|integer',
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        if(!$artista){
            return response()->json(['message' => 'Artista não encontrado', 404]);
        }        
        
        $path = $request->file('file')->store('fotos/'.$request->art_id, 's3');
        //$path = Storage::disk('s3')->put('uploads/{$request->art_id}', $request->file('file'));
        
        $foto = FotoAlbum::create([
            'art_id' => $artista->art_id,
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

    public function uploadss(Request $request)
    {
        /*        
        $pessoa = Pessoa::findOrFail($request->pes_id);
        //$fileName = Str::uuid() . '.' . $request->file->extension();
        //$path = Storage::disk('s3')->put("fotos/{$fileName}", $request->file, 'public');        
        $path = $request->file('file')->store('fotos/uploads', 's3');
        $foto = FotoPessoa::create([
            'pes_id' => $pessoa->pes_id,
            'fp_bucket' => env('AWS_BUCKET'),
            'fp_hash' => $path,
            'fp_data' => now(),
        ]);
        return response()->json([
            'message' => 'Foto enviada com sucesso!',
            'foto_url' => $path,
        ]);
        */

        //dd($request->pes_id);
        

        
        $request->validate([
            'pes_id' => 'required|integer',
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $path = Storage::disk('s3')->put('uploads', $request->file('file'));

        $foto = FotoAlbum::create([
            'art_id' => $request->art_id,
            'fa_bucket' => env('AWS_BUCKET'),
            'fa_hash' => $path,
            'fa_data' => now(),
        ]);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'path' => $path,
            'url' => Storage::disk('minio')->url($path),
        ]);
        
    }
}
