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
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ForgotPasswordMessage;
use App\Http\Requests\ResetPasswordRequest;

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

  //exige apenas a senha antiga do usuario para poder criar uma nova
  public function changePassword(ChangePasswordRequest $request)
  {
    $credentials = array('email' => Auth::user()->email, 'password' => $request->input('oldPassword'));

    if(!auth()->validate($credentials)){
      return response()->json(['error' => 'Senha incorreta!']);
    }

    /*if (!$request->input('newPassword') == $request->input('newPasswordConfirmation')) {
      return response()->json(['error' => 'Você digitou senhas diferentes']);
    } já tratei isso na request*/

    //envia apenas uma hash da senha para o BD
    Auth::user()->password = bcrypt($request->input('newPassword'));
    Auth::user()->save();

    //invalida token anterior e cria um novo
    $newToken = auth()->refresh();

    return response()->json(['token' => $newToken, 'message' => 'Senha alterada com sucesso']);

  }

  //envia email com um codigo para o usuario 'esquecido' criar uma nova senha
  public function forgotPassword(ForgotPasswordRequest $request)
  {
    $email = $request->input('email');
    $user = User::where('email', $email)->firstOrFail();

    //gera uma string aleatoria a partir de duas funcoes do php e associa ao usuario em questao no BD
    $passcode = bin2hex(random_bytes(20));
    $user->passcode = $passcode;
    $user->save();

    //funcao notify envia notificacao para o usuario via email com o 'passcode'
    $user->notify(new ForgotPasswordMessage($passcode));
    return response()->json(['message' => 'Enviaremos uma mensagem para o seu email. Isso pode levar alguns minutos.']);
  }

  //a funcao q realmente reseta a senha no BD
  public function resetForgotPassword(ResetPasswordRequest $request)
  {
    $user = User::where('email', $request->input('email'))->firstOrFail();
    //verifica o passcode do usuario (possivel vulnerabilidade se o usuario conseguir passar um valor nulo)
    if(!$request->input('passcode') === $user->passcode)
    {
      return response()->json(['error' => 'O código está incorreto.']);
    }
    //envia hash da senha pro BD
    $user->password = bcrypt($request->input('newPassword'));
    //anula o passcode do usuario, para q nao seja mais possivel resetar sua senha com o msm codigo
    $user->passcode = null;
    $user->save();
    return response()->json(['message' => 'A nova senha foi criada com sucesso']);
  }
}
