<?php
// app/Models/Historique.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Historique extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'formation_id', 'user_concerne_id', 'type_action', 'details'
    ];

    protected $casts = [
        'date_action' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function userConcerne()
    {
        return $this->belongsTo(User::class, 'user_concerne_id');
    }

    // Méthode statique pour enregistrer les actions
    public static function enregistrerAction($typeAction, $details, $formationId = null, $userConcerneId = null)
    {
        return self::create([
            'user_id' => Auth::id(),
            'formation_id' => $formationId,
            'user_concerne_id' => $userConcerneId,
            'type_action' => $typeAction,
            'details' => $details
        ]);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type_action', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}