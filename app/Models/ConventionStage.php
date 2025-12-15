<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConventionStage extends Model
{
    use HasFactory;

    protected $table = 'conventions_stage';
    protected $primaryKey = 'id_convention';

    protected $fillable = [
        'id_demande',
        'id_etudiant',
        'nom_entreprise',
        'adresse_entreprise',
        'email_entreprise',
        'nom_encadrant_entreprise',
        'nom_encadrant_ecole',
        'sujet_stage',
        'duree_stage',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'id_demande');
    }
}
