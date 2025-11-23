<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    // Public formations listing
    public function index()
    {
        return view('formations.index');
    }

    // Public formation details
    public function show(Formation $formation)
    {
        return view('formations.show', compact('formation'));
    }

    // ===== Formateur actions =====
    public function create()
    {
        // Ensure only formateurs can access this
        if (!auth()->user()->isFormateur()) {
            abort(403, 'Seuls les formateurs peuvent créer des formations.');
        }
        
        return view('formateur.create-formation');
    }

    public function store(Request $request)
    {
        // Ensure only formateurs can access this
        if (!auth()->user()->isFormateur()) {
            abort(403, 'Seuls les formateurs peuvent créer des formations.');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'duree' => 'required|integer|min:1|max:200',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'required',
            'capacite_max' => 'required|integer|min:1|max:100',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'duree.required' => 'La durée est obligatoire.',
            'duree.integer' => 'La durée doit être un nombre entier.',
            'duree.min' => 'La durée doit être d\'au moins 1 heure.',
            'duree.max' => 'La durée ne peut pas dépasser 200 heures.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'heure_debut.required' => 'L\'heure de début est obligatoire.',
            'capacite_max.required' => 'La capacité maximale est obligatoire.',
            'capacite_max.integer' => 'La capacité maximale doit être un nombre entier.',
            'capacite_max.min' => 'La capacité maximale doit être d\'au moins 1 participant.',
            'capacite_max.max' => 'La capacité maximale ne peut pas dépasser 100 participants.',
        ]);

        try {
            $formation = Formation::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'duree' => $request->duree,
                'formateur_id' => auth()->id(),
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'heure_debut' => $request->heure_debut,
                'capacite_max' => $request->capacite_max,
                'statut' => 'ATTENTE_VALIDATION', // New formations need admin approval
                'terminee' => false,
            ]);

            return redirect()->route('formateur.formations.index')
                ->with('success', 'Formation créée avec succès ! Elle sera soumise pour validation par l\'administration.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la création de la formation. Veuillez réessayer.']);
        }
    }

    public function edit(Formation $formation)
    {
        // Ensure only formateurs can access this
        if (!auth()->user()->isFormateur()) {
            abort(403, 'Seuls les formateurs peuvent modifier des formations.');
        }

        // Ensure the formation belongs to the authenticated formateur
        if ($formation->formateur_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres formations.');
        }

        // Prevent editing of formations that are already active or completed
        if ($formation->statut === 'ACTIVE' && $formation->inscriptions()->count() > 0) {
            return redirect()->route('formateur.formations.index')
                ->withErrors(['error' => 'Impossible de modifier une formation active avec des participants inscrits.']);
        }

        return view('formateur.edit-formation', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        // Ensure only formateurs can access this
        if (!auth()->user()->isFormateur()) {
            abort(403, 'Seuls les formateurs peuvent modifier des formations.');
        }

        // Ensure the formation belongs to the authenticated formateur
        if ($formation->formateur_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres formations.');
        }

        // Prevent editing of formations that are already active with participants
        if ($formation->statut === 'ACTIVE' && $formation->inscriptions()->count() > 0) {
            return redirect()->route('formateur.formations.index')
                ->withErrors(['error' => 'Impossible de modifier une formation active avec des participants inscrits.']);
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'duree' => 'required|integer|min:1|max:200',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'required',
            'capacite_max' => 'required|integer|min:1|max:100',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'duree.required' => 'La durée est obligatoire.',
            'duree.integer' => 'La durée doit être un nombre entier.',
            'duree.min' => 'La durée doit être d\'au moins 1 heure.',
            'duree.max' => 'La durée ne peut pas dépasser 200 heures.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'heure_debut.required' => 'L\'heure de début est obligatoire.',
            'capacite_max.required' => 'La capacité maximale est obligatoire.',
            'capacite_max.integer' => 'La capacité maximale doit être un nombre entier.',
            'capacite_max.min' => 'La capacité maximale doit être d\'au moins 1 participant.',
            'capacite_max.max' => 'La capacité maximale ne peut pas dépasser 100 participants.',
        ]);

        try {
            $formation->update([
                'titre' => $request->titre,
                'description' => $request->description,
                'duree' => $request->duree,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'heure_debut' => $request->heure_debut,
                'capacite_max' => $request->capacite_max,
                // Reset status to pending validation if it was rejected
                'statut' => $formation->statut === 'REFUSEE' ? 'ATTENTE_VALIDATION' : $formation->statut,
            ]);

            return redirect()->route('formateur.formations.index')
                ->with('success', 'Formation modifiée avec succès !');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la modification de la formation. Veuillez réessayer.']);
        }
    }

    public function terminate(Formation $formation)
    {
        return redirect()->route('formateur.formations.index')
            ->with('status', 'Termination de formation non implémentée pour le moment.');
    }
}