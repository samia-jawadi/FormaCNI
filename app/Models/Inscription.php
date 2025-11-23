<?php
// app/Models/Inscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = ['participant_id', 'formation_id', 'statut'];

    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    // Relations
    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    // Méthodes
    public function confirmer()
    {
        $this->update(['statut' => 'CONFIRMEE']);
    }

    public function refuser()
    {
        $this->update(['statut' => 'REFUSEE']);
    }

    public function annuler()
    {
        $this->update(['statut' => 'ANNULEE']);
    }

    // Scopes
    public function scopeConfirmee($query)
    {
        return $query->where('statut', 'CONFIRMEE');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'EN_ATTENTE');
    }
}