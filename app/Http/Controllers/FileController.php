<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\FotoPessoa;

class FileController extends Controller
{
    public function index()
    {
        return File::all();
        // Arquivos
    }

    public function store(Request $request)
    {
        $request->validate([
            'pes_id' => 'required|integer',
            'file' => 'required|file'
        ]);

        $path = Storage::disk('s3')->put('uploads', $request->file('file'));

        /*
        $file = File::create([
            'filename' => $request->file('file')->getClientOriginalName(),
            'path' => $path
        ]);
        */

        $fotoPessoa = FotoPessoa::create([                        
            'pes_id' => $request->pes_id,
            'fp_data' => '2025-04-04',
            'fp_bucket' => 'mybucket',
            'fp_hash' => $request->file('file')->getClientOriginalName(),
        ]);

        return response()->json($fotoPessoa, 201);
    }

    public function show(File $file)
    {
        return response()->json([
            'url' => Storage::disk('s3')->url($file->path)
        ]);
    }

    public function destroy(File $file)
    {
        Storage::disk('s3')->delete($file->path);
        $file->delete();

        return response()->noContent();
    }
}
