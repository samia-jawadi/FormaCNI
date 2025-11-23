<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Formation $formation)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->isParticipant()) {
            return back()->withErrors(['error' => 'Seuls les participants peuvent s\'inscrire']);
        }

        // Check if formation is available
        if (!$formation->estActive()) {
            return back()->withErrors(['error' => 'Cette formation n\'est pas disponible pour inscription']);
        }

        // Check if formation is full
        if ($formation->estComplete()) {
            return back()->withErrors(['error' => 'Cette formation est complète']);
        }

        // Check if user is already inscribed
        $existingInscription = Inscription::where('participant_id', $user->id)
            ->where('formation_id', $formation->id)
            ->first();

        if ($existingInscription) {
            return back()->withErrors(['error' => 'Vous êtes déjà inscrit à cette formation']);
        }

        Inscription::create([
            'participant_id' => $user->id,
            'formation_id' => $formation->id,
            'statut' => 'EN_ATTENTE'
        ]);

        return back()->with('success', 'Inscription réussie ! Votre inscription sera validée sous peu.');
    }

    public function mesFormations()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $formations = $user->formationsInscrites()
            ->withPivot('statut', 'date_inscription')
            ->with('formateur')
            ->latest('inscriptions.created_at')
            ->paginate(10);

        return view('participant.formations', compact('formations'));
    }

    public function mesInscriptions()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $inscriptions = $user->inscriptions()
            ->with(['formation', 'formation.formateur'])
            ->latest()
            ->paginate(10);

        return view('participant.inscriptions', compact('inscriptions'));
    }
}
