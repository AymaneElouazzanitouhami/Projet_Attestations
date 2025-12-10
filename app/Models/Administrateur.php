<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash; // Important d'importer Hash

class Administrateur extends Authenticatable
{
    use HasFactory;

    protected $table = 'administrateurs';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nom_complet',
        'email',
        'mot_de_passe',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Indique à Laravel que la colonne du mot de passe s'appelle 'mot_de_passe'.
     * Utile pour la LECTURE du mot de passe.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * CORRECTION FINALE : Intercepte les tentatives d'ÉCRITURE dans 'password'.
     * Quand Laravel essaie de mettre à jour le 'password', cette méthode
     * s'assure que c'est bien la colonne 'mot_de_passe' qui est modifiée.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['mot_de_passe'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }
}

