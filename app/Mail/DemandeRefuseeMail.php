<?php

namespace App\Mail;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeRefuseeMail extends Mailable
{
    use Queueable, SerializesModels;

    public Demande $demande;
    public string $motif;

    public function __construct(Demande $demande, string $motif)
    {
        $this->demande = $demande;
        $this->motif = $motif;
    }

    public function build(): self
    {
        return $this->subject("Votre demande d'attestation a été refusée")
                    ->view('emails.demande_refusee');
    }
}
