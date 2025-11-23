<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description', 
        'duree',
        'formateur_id',
        'date_debut',
        'date_fin', 
        'heure_debut',
        'capacite_max',
        'statut',
        'terminee'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        // heure_debut may be stored as time or string; keep raw and format via accessor
        'terminee' => 'boolean',
    ];

    // Relations
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'inscriptions', 'formation_id', 'participant_id')
                    ->withPivot('statut', 'date_inscription');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('statut', 'ACTIVE')->where('terminee', false);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'ATTENTE_VALIDATION');
    }

    public function scopeTerminee($query)
    {
        return $query->where(function($q){
            $q->where('terminee', true)->orWhere('statut', 'TERMINEE');
        });
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'ACTIVE')->where('terminee', false);
    }

    // Méthodes utilitaires
    public function estActive()
    {
        return $this->statut === 'ACTIVE' && !$this->estTerminee();
    }

    public function estEnAttente()
    {
        return $this->statut === 'ATTENTE_VALIDATION';
    }

    public function estTerminee()
    {
        return (bool)$this->terminee || $this->statut === 'TERMINEE';
    }

    public function estComplete()
    {
        return $this->inscriptions()->count() >= $this->capacite_max;
    }

    public function getNombreInscriptions()
    {
        return $this->inscriptions()->count();
    }

    public function getPlacesRestantes()
    {
        return $this->capacite_max - $this->getNombreInscriptions();
    }

    public function peutEtreInscrit()
    {
        return $this->estActive() && !$this->estComplete() && !$this->estTerminee();
    }

    // Accessors
    public function getStatutBadgeAttribute()
    {
        if ($this->estTerminee()) {
            return 'bg-purple-100 text-purple-800';
        }
        $badges = [
            'ACTIVE' => 'bg-green-100 text-green-800',
            'ATTENTE_VALIDATION' => 'bg-yellow-100 text-yellow-800',
            'REFUSEE' => 'bg-red-100 text-red-800',
            'DESACTIVEE' => 'bg-gray-200 text-gray-800'
        ];

        return $badges[$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatutLibelleAttribute()
    {
        if ($this->estTerminee()) {
            return 'Terminée';
        }
        $libelles = [
            'ACTIVE' => 'Active',
            'ATTENTE_VALIDATION' => 'En attente de validation',
            'REFUSEE' => 'Refusée',
            'DESACTIVEE' => 'Désactivée'
        ];

        return $libelles[$this->statut] ?? 'Inconnu';
    }

    public function getDureeFormateeAttribute()
    {
        return $this->duree . ' heure' . ($this->duree > 1 ? 's' : '');
    }

    public function getDateFormateeAttribute()
    {
        if ($this->date_debut && $this->date_fin) {
            if ($this->date_debut->equalTo($this->date_fin)) {
                return $this->date_debut->format('d/m/Y');
            } else {
                return $this->date_debut->format('d/m/Y') . ' - ' . $this->date_fin->format('d/m/Y');
            }
        }
        return 'Dates non définies';
    }

    public function getHeureDebutFormatteeAttribute()
    {
        // Handle time stored as string, Carbon or DateTime
        $val = $this->attributes['heure_debut'] ?? null;
        if (!$val) return '';
        try {
            if ($this->getAttribute('heure_debut') instanceof \DateTimeInterface) {
                return $this->getAttribute('heure_debut')->format('H:i');
            }
            // Normalize possible formats
            return date('H:i', strtotime($val));
        } catch (\Throwable $e) {
            return (string) $val;
        }
    }

    public function getProgressionAttribute()
    {
        if ($this->capacite_max == 0) return 0;
        return round(($this->getNombreInscriptions() / $this->capacite_max) * 100, 1);
    }

    // Méthodes de gestion du statut
    public function approuver()
    {
        $this->update(['statut' => 'ACTIVE']);
    }

    public function rejeter()
    {
        $this->update(['statut' => 'REFUSEE']);
    }

    public function terminer()
    {
        $this->update(['statut' => 'TERMINEE', 'terminee' => true]);
    }
}

