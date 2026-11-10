<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/login → entrega un token Bearer.
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        // Mismo mensaje si el correo no existe o la contraseña está mal: no damos pistas.
        if ($user === null || ! Hash::check($request->validated('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no son correctas.',
            ]);
        }

        $permisos = $request->boolean('solo_lectura')
            ? ['alumnos:leer']
            : ['alumnos:leer', 'alumnos:escribir'];

        $token = $user->createToken(
            $request->validated('nombre_dispositivo'),
            $permisos,
            now()->addHours(8),
        );

        return response()->json([
            'token' => $token->plainTextToken,
            'tipo' => 'Bearer',
            'permisos' => $permisos,
            'expira' => $token->accessToken->expires_at?->toIso8601String(),
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/yo → datos del usuario dueño del token.
     */
    public function yo(Request $request): JsonResponse
    {
        return response()->json([
            'nombre' => $request->user()->name,
            'email' => $request->user()->email,
            'permisos' => $request->user()->currentAccessToken()->abilities,
        ]);
    }

    /**
     * POST /api/logout → revoca el token actual.
     */
    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
