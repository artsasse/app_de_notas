<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\Http\Requests\SignInForm;
use App\Http\Requests\SignUpForm;

class AuthController extends Controller
{
  public function signup(SignUpForm $request){
    /*$this->validate($request, [
      'name' => 'required',
      'email' => 'email|required|unique:users',
      'password'=> 'required'
    ]);*/

    $usuario_novo = new User;

    $usuario_novo->name = $request->input('name');
    $usuario_novo->email = $request->input('email');
    $usuario_novo->password = bcrypt($request->input('password'));

    $usuario_novo->save();

    return response()->json(['message' => 'Usuario criado com sucesso!']);
  }

  public function signin(SignInForm $request){
    /*$this->validate($request, [
      'email' => 'email|required',
      'password'=> 'required'
    ]);*/

    $credentials = $request->only('email', 'password');

    try{
      if(!$token = JWTAuth::attempt($credentials)){
        return response()->json(['error' => 'Houve erro no login!']);
      }
    }
    catch(JWTException $e){
      return response()->json(['error' => 'Nao foi possivel gerar o token']);
    }

    return response()->json(['token' => $token]);
  }
}
