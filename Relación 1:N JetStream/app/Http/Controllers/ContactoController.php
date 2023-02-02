<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function pintarFormulario()
    {
        return view('contacto.form');
    }

    public function procesarFormulario(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'min:3'],
            'contenido' => ['required', 'string', 'min:10'],
        ]);
        try {
            Mail::to('admin@sitio.org')->send(new ContactoMailable($request->all()));
            return redirect()->route('dashboard')->with('mensaje', 'Mensaje enviado');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('mensaje', 'No se puedo enviar el correo, intentelo mas tarde');
        }
    }
}