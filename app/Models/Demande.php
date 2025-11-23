<?php
// app/Models/Demande.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'formateur_id', 'titre', 'description', 'duree_proposee', 'statut', 'raison_refus'
    ];

    protected $casts = [
        'date_soumission' => 'datetime',
    ];

    // Relations
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }

    // Méthodes
    public function accepter()
    {
        $this->update(['statut' => 'ACCEPTEE']);
    }

    public function refuser($raison = null)
    {
        $this->update([
            'statut' => 'REFUSEE',
            'raison_refus' => $raison
        ]);
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'EN_ATTENTE');
    }

    public function scopeAcceptee($query)
    {
        return $query->where('statut', 'ACCEPTEE');
    }
}