<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
    * @OA\Post(
    *     path="/api/login",
    *     summary="Autenticar usuário",
    *     tags={"Autenticação"},
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="Informe o email",
    *         required=true,
    *         example="teste@seplag.mt.gov.br",
    *         @OA\MediaType(
    *            mediaType="application/json",
    *         ),
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         description="Insira a senha",
    *         required=true,
    *         example="seplag2025",
    *         @OA\MediaType(
    *            mediaType="application/json",
    *         ),
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(response="200", description="Successo no Login"),
    *     @OA\Response(response="401", description="Credenciais inválidas")
    * )
    */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        // Cria token válido por 5 minutos
        $token = $user->createToken('auth-token', ['*'], now()->addMinutes(5))->plainTextToken;

        return response()->json(['token' => $token]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
    * @OA\Post(
    *     path="/api/refresh",
    *     summary="Renovar Token",
    *     tags={"Autenticação"},
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="Informe um email",
    *         required=true,
    *         example="teste@seplag.mt.gov.br",
    *         @OA\MediaType(
    *            mediaType="application/json",
    *         ),
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         description="Insira a senha",
    *         required=true,
    *         example="seplag2025",
    *         @OA\MediaType(
    *            mediaType="application/json",
    *         ),
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(response="200", description="Successo no Refresh"),
    *     @OA\Response(response="401", description="Credenciais inválidas")
    * )
    */
    public function refresh(Request $request)
    {        
        $user = $request->user();
        //$request->user()->tokens()->delete(); // Revoga tokens antigos
        $user->tokens()->delete();
        $newToken = $user->createToken('auth-token', ['*'], now()->addMinutes(5))->plainTextToken;
        return response()->json(['token_new' => $newToken]);        
    }
}
