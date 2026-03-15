<?php

namespace App\Mail;

use App\Models\Parte;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ParteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Parte $parte) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Parte de apercibimiento - {$this->parte->alumno->nombre_completo}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.parte',  // resources/views/emails/parte.blade.php
        );
    }
}