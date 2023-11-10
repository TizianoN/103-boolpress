<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use App\Http\Controllers\Controller;
use App\Mail\NewMessage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class MessageFormController extends Controller
{
  public function store(Request $request)
  {
    // abort(500, "Messaggio di errore forzato");

    $data = $request->all();

    $name = $data['name'];
    $email = $data['email'];
    $message = $data['message'];

    $destinatario = User::find(1);
    Mail::to($destinatario->email)->send(new NewMessage($name, $email, $message));
  }
}