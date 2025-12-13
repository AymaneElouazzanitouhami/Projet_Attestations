<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'id_etudiant',
        'module_name',
        'note',
        'semestre',
        'annee_universitaire',
        'resultat',
        'remarques'
    ];

    protected $table = 'notes';

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant', 'id_etudiant');
    }
}