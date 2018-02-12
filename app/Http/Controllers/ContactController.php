<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactForm;
use App\Notifications\UserMessage;
use App\Admin;
use Illuminate\Support\Facades\Auth;


class ContactController extends Controller
{
    public function sendEmail(ContactForm $message, Admin $admin)
    {
      $message->name = Auth::user()->name;
      $message->email = Auth::user()->email;

      //envia notificacao(email) pro admin
      $admin->notify(new UserMessage($message));

      return response()->json(["message" => "Obrigado pela mensagem! Vamos responder o mais rápido possível!"]);
    }
}
