<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        //validación de los datos
        $rules = [
            'name' => 'required',
            'lastName' => 'required',
            'documentType' => 'required',
            'documentNumber' => 'required|string|unique:users,documentNumber',
            'nationality' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ];

        $validator = \Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        //alta del usuario
        $user = new User();
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->documentType = $request->documentType;
        $user->documentNumber = $request->documentNumber;
        $user->nationality = $request->nationality;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'Data' => $user,
            'status' => Response::HTTP_CREATED,
        ], Response::HTTP_OK);
    }

    public function login(Request $request): \Illuminate\Foundation\Application  | \Illuminate\Http\Response  | \Illuminate\Http\JsonResponse  | \Illuminate\Contracts\Foundation\Application  | \Illuminate\Contracts\Routing\ResponseFactory
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status == 1) {
                $token = $user->createToken('token')->plainTextToken;
                $cookie = cookie('cookie_token', $token, 60 * 24);
                return response()->json([
                    "status" => true,
                    "data" => $user,
                    "token" => $token,
                ], Response::HTTP_OK)->withoutCookie($cookie);
            } else {
                auth()->user()->tokens()->delete();
                return response(["message" => "Usuario no autorizado"], Response::HTTP_UNAUTHORIZED);
            }

        } else {
            return response(["message" => "Credenciales inválidas"], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function userProfile(): \Illuminate\Http\JsonResponse
    {
        if (auth()->user()->status == 1) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "data" => auth()->user(),
            ], Response::HTTP_OK);
        } else {
            auth()->user()->tokens()->delete();
            return response()->json([
                "message" => "Usuario no autorizado",
            ], Response::HTTP_UNAUTHORIZED);

        }

    }

    public function changeUserStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::find($request->id);

        $user->status = $request->status;
        $user->save();

        if ($request->status == 1) {
            return response()->json([
                "message" => "Usuario autorizado",
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Usuario no autorizado",
            ], Response::HTTP_OK);

        }
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "Sesión cerrada",
        ], Response::HTTP_OK);

    }
}
