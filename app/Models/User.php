<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @method bool isAdmin()
 * @method bool isFormateur() 
 * @method bool isParticipant()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'email', 'password', 'role', 'pronoms', 'photo', 'adresse',
        'specialite', 'experience', 'cv_path', 'niveau', 'preferences', 'est_actif', 'deactivated_at',
        'est_stagiere'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'preferences' => 'array',
        'est_actif' => 'boolean',
        'est_stagiere' => 'boolean',
        'deactivated_at' => 'datetime',
    ];

    // Relations
    public function formations()
    {
        return $this->hasMany(Formation::class, 'formateur_id');
    }

    public function formationsCrees()
    {
        return $this->hasMany(Formation::class, 'formateur_id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'formateur_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'participant_id');
    }

    public function formationsInscrites()
    {
        return $this->belongsToMany(Formation::class, 'inscriptions', 'participant_id', 'formation_id')
                    ->withPivot('statut', 'date_inscription');
    }

    // Méthodes utilitaires
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFormateur()
    {
        return $this->role === 'formateur';
    }

    public function isParticipant()
    {
        return $this->role === 'participant';
    }
    
    public function isStagiere()
    {
        return $this->est_stagiere === true;
    }

    // Additional helper methods
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->nom, 0, 1));
    }

    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => 'bg-purple-100 text-purple-800',
            'formateur' => 'bg-blue-100 text-blue-800', 
            'participant' => 'bg-green-100 text-green-800'
        ];

        return $badges[$this->role] ?? 'bg-gray-100 text-gray-800';
    }

    public function canCreateFormation()
    {
        return $this->isFormateur() || $this->isAdmin();
    }

    public function canViewAdminPanel()
    {
        return $this->isAdmin();
    }

    // Accessors for formatted data
    public function getFormattedExperienceAttribute()
    {
        if (!$this->experience) return 'Non spécifié';
        return $this->experience . ' an' . ($this->experience > 1 ? 's' : '');
    }

    public function getFormationsCountAttribute()
    {
        return $this->formations()->count();
    }

    public function getActiveFormationsCountAttribute()
    {
        return $this->formations()->where('statut', 'ACTIVE')->count();
    }

    public function getPendingFormationsCountAttribute()
    {
        return $this->formations()->where('statut', 'ATTENTE_VALIDATION')->count();
    }

    public function getPendingDemandesCountAttribute()
    {
        return $this->demandes()->where('statut', 'EN_ATTENTE')->count();
    }
}