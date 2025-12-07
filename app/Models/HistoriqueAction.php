<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueAction extends Model
{
    use HasFactory;

    protected $table = 'historique_actions';
    protected $primaryKey = 'id_historique';
    public $timestamps = false;

    protected $casts = [
        'date_action' => 'datetime',
    ];

    protected $fillable = [
        'id_demande', 'id_reclamation', 'id_admin', 
        'action_effectuee', 'details', 'date_action'
    ];
    
    // Relations optionnelles pour affichage
    public function admin() { return $this->belongsTo(Administrateur::class, 'id_admin'); }
}