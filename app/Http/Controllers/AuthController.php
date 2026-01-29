<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Autenticar usuário",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="teste@seplag.mt.gov.br"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="seplag2026"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     *)
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

        // Limpa tokens anteriores (opcional, para manter apenas um acesso por vez)
        $user->tokens()->delete();

        $token = $user->createToken(
            'auth-token',
            ['*'],
            now()->addMinutes(5)
        )->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * summary="Encerrar sessão",
     * tags={"Autenticação"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Logout realizado"),
     * @OA\Response(response=401, description="Não autenticado")
     * )
     */
    
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso']);
        }

        return response()->json(['error' => 'Usuário não autenticado'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Renovar token de autenticação",
     *     tags={"Autenticação"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token renovado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token_new", type="string", example="1|eyJ0eXAiOiJKV1QiLCJhbGci...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido ou expirado"
     *     )
     * )
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        // Se o token atual for inválido, o $user será null
        if (!$user) {
            return response()->json(['error' => 'Token inválido ou usuário não encontrado'], 401);
        }

        $user->tokens()->delete();

        $newToken = $user->createToken(
            'auth-token',
            ['*'],
            now()->addMinutes(5)
        )->plainTextToken;

        return response()->json(['token_new' => $newToken]);
    }
}
