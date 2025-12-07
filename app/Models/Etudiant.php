<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';
    protected $primaryKey = 'id_etudiant';
    public $timestamps = false; // Si vous n'avez pas created_at/updated_at

    protected $fillable = [
        'nom', 'prenom', 'email', 'cin', 'numero_apogee', 
        'niveau_actuel', 'filiere_actuelle', 'statut_inscription', 
        'parcours_sans_redoublement'
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'id_etudiant');
    }
}