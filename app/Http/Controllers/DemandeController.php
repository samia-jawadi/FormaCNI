<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
/** @var \App\Models\User $user */
        if (!$user->isFormateur()) abort(403);

        $demandes = $user->demandes()->get();
        return view('demandes.index', compact('demandes'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree_proposee' => 'nullable|integer|min:1'
        ]);

        Demande::create([
            'formateur_id' => $user->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'duree_proposee' => $request->duree_proposee,
            'statut' => 'EN_ATTENTE'
        ]);

        return redirect()->route('formateur.demandes.index')->with('success', 'Demande créée et envoyée pour validation');
    }

    public function create()
    {
        return view('demandes.create');
    }

    public function show(Demande $demande)
    {
        // Only allow formateur to view their own demandes
        if ($demande->formateur_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez voir que vos propres demandes');
        }

        return view('demandes.show', compact('demande'));
    }
}
