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
    public ?string $pdfContent;
    public ?string $fileName;

    public function __construct(Demande $demande, $etudiant, ?string $pdfContent = null, ?string $fileName = null)
    {
        $this->demande = $demande;
        $this->etudiant = $etudiant;
        $this->pdfContent = $pdfContent;
        $this->fileName = $fileName ?? 'attestation.pdf';
    }

    public function build(): self
    {
        $mail = $this->subject("Votre attestation - ENSA Tétouan")
                     ->view('emails.demande_validee');

        // Attacher le PDF uniquement s'il existe
        if ($this->pdfContent) {
            $mail->attachData($this->pdfContent, $this->fileName, [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}