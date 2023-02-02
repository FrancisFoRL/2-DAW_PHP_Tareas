<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

    //Tienen que ser public 
    public string $nombre;
    public string $contenido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $datos)
    {
        $this->nombre=$datos['nombre'];
        $this->contenido=$datos['contenido'];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope() 
    {
        return new Envelope(
            from: new Address(
                auth()->user()->email, $this->nombre), 
            subject: 'Formulario de contacto', 
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'correo.contacto',
            with:[
                'nombre' => $this->nombre,
                'email' => auth()->user()->email,
                'contenido' => $this->contenido
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}