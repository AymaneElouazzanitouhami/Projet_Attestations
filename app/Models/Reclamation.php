<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    protected $table = 'reclamations';
    protected $primaryKey = 'id_reclamation';
    public $timestamps = false;

    protected $casts = [
        'date_reclamation' => 'datetime',
    ];

    protected $fillable = [
        'id_demande_concernee', 'id_etudiant', 'sujet', 
        'description', 'statut', 'date_reclamation', 'reponse_admin'
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'id_demande_concernee');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }
}