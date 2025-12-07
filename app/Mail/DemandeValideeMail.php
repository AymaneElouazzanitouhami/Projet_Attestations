<?php

namespace App\Mail;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeValideeMail extends Mailable
{
    use Queueable, SerializesModels;

    public Demande $demande;
    public $etudiant;
    protected string $pdfContent;

    public function __construct(Demande $demande, $etudiant, string $pdfContent)
    {
        $this->demande = $demande;
        $this->etudiant = $etudiant;
        $this->pdfContent = $pdfContent;
    }

    public function build(): self
    {
        $fileName = 'attestation_scolarite.pdf';

        return $this->subject("Votre attestation de scolarité - ENSA Tétouan")
                    ->view('emails.demande_validee')
                    ->attachData($this->pdfContent, $fileName, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
