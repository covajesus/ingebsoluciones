<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        // Enviar el correo electrónico sin validar los datos del formulario
        $recipient = 'contacto@ingebsoluciones.cl';
        Mail::to($recipient)->send(new ContactMessage($request->all()));

        // Retornar una respuesta si es necesario
        return response()->json(['message' => 'Correo electrónico enviado correctamente'], 200);
    }
}
