<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\Http\Requests\SignInForm;
use App\Http\Requests\SignUpForm;
use Illuminate\Support\Collection;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;

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

  public function changePassword(ChangePasswordRequest $request)
  {
    $credentials = array('email' => Auth::user()->email, 'password' => $request->input('oldPassword'));

    if(!auth()->validate($credentials)){
      return response()->json(['error' => 'Senha incorreta!']);
    }

    /*if (!$request->input('newPassword') == $request->input('newPasswordConfirmation')) {
      return response()->json(['error' => 'Você digitou senhas diferentes']);
    }*/

    Auth::user()->password = $request->input('newPassword');
    Auth::user()->save();

    $newToken = auth()->refresh();

    return response()->json(['token' => $newToken, 'message' => 'Senha alterada com sucesso']);

  }

  /*public function forgotPassword(ForgotPasswordRequest $request)
  {
    $userEmail = User::where('email', $request->input('email'))->firstOrFail()->email;
    //send email with 'tokenized' link*/


  }
  //private function reseta senha sem pedir senha anterior
}
