<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $table = 'demandes';
    protected $primaryKey = 'id_demande';
    public $timestamps = false; // Selon votre script SQL final

    // Indique que date_demande est une date pour pouvoir utiliser ->format()
    protected $casts = [
        'date_demande' => 'datetime',
        'date_traitement' => 'datetime',
    ];

    protected $fillable = [
        'id_etudiant', 'type_document', 'statut', 'date_demande',
        'annee_universitaire', 'semestre', 
        'id_admin_traitant', 'date_traitement', 'motif_refus'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'id_admin_traitant');
    }
}