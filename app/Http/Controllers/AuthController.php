<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
  public function signup(Request $request){
    $this->validate($request, [
      'name' => 'required',
      'email' => 'email|required|unique:users',
      'password'=> 'required'
    ]);

    $usuario_novo = new User;

    $usuario_novo->name = $request->name;
    $usuario_novo->email = $request->email;
    $usuario_novo->password = bcrypt($request->password);

    $usuario_novo->save();

    return response()->json(['msg' => 'Usuario criado com sucesso!']);
  }

  public function signin(Request $request){
    $this->validate($request, [
      'email' => 'email|required',
      'password'=> 'required'
    ]);

    $credentials = $request->only('email', 'password');

    try{
      if(!$token = JWTAuth::attempt($credentials)){
        return response()->json(['error' => 'Houve erro no login!']);
      }
    }
    catch(JWTException $e){
      return response()->json(['Nao foi possivel gerar o token']);
    }

    return response()->json(['token' => $token]);
  }
}
