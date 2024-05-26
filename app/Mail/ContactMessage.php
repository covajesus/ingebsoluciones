<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contacto@ingebsoluciones.com') // Dirección de correo electrónico que se mostrará como remitente
                    ->subject('Nuevo mensaje de contacto') // Asunto del correo electrónico
                    ->view('emails.contact_message') // Vista Blade que contiene el cuerpo del correo electrónico
                    ->with(['formData' => $this->formData]); // Datos que se pasan a la vista
    }
}