<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FormateurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user->isFormateur()) {
                abort(403, 'Accès non autorisé. Seuls les formateurs peuvent accéder à cette section.');
            }

            return $next($request);
        });
    }

    /**
     * Display the formateur dashboard
     */
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
http://127.0.0.1:8000/formateur/mes-formations
        // Statistiques pour les cartes du tableau de bord
        $stats = [
            'total_formations'   => Formation::count(),
            'my_formations'      => $user->formations()->count(),
            'total_participants' => User::where('role', 'participant')->count(),
        ];

        // Formations disponibles (lecture seule, paginées)
        $allFormations = Formation::with(['formateur'])
            ->latest()
            ->paginate(10);

        // Mes formations récentes
        $myFormations = $user->formations()
            ->with(['inscriptions'])
            ->latest()
            ->get();

        return view('formateur.dashboard', compact(
            'stats',
            'allFormations',
            'myFormations'
        ));
    }

    /**
     * Display formateur's formations
     */
    public function myFormations(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->formations()
            ->withCount(['inscriptions as confirmed_inscriptions_count' => function($query) {
                $query->where('statut', 'CONFIRMEE');
            }])
            ->withCount('inscriptions');

        // Apply filters
        if ($request->has('statut') && $request->statut) {
            $query->where('statut', $request->statut);
        }

        if ($request->has('search') && $request->search) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        // Full collection to match view expectations ($myFormations)
        $myFormations = $query->latest()->get();

        return view('formateur.my-formations', compact('myFormations'));
    }

    /**
     * Show a specific formation with participants
     */
    public function showFormation(Formation $formation)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if the formation belongs to this formateur
        if ($formation->formateur_id !== $user->id) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette formation.');
        }

        // Load formation with participants
        $formation->load([
            'participants' => function($query) {
                $query->withPivot('statut', 'date_inscription')
                      ->orderBy('inscriptions.created_at', 'desc');
            }
        ]);

        // Get inscription statistics
        $inscriptionStats = [
            'total' => $formation->inscriptions()->count(),
            'confirmed' => $formation->inscriptions()->where('statut', 'CONFIRMEE')->count(),
            'pending' => $formation->inscriptions()->where('statut', 'EN_ATTENTE')->count(),
            'cancelled' => $formation->inscriptions()->where('statut', 'ANNULEE')->count(),
        ];

        return view('formateur.show-formation', compact('formation', 'inscriptionStats'));
    }

    /**
     * Remove a participant from a formation
     */
    public function removeParticipant(Formation $formation, User $participant)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if the formation belongs to this formateur
        if ($formation->formateur_id !== $user->id) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette formation.');
        }

        // Find the inscription
        $inscription = Inscription::where('formation_id', $formation->id)
            ->where('participant_id', $participant->id)
            ->first();

        if (!$inscription) {
            return redirect()->back()->with('error', 'Participant non trouvé dans cette formation.');
        }

        // Remove the participant
        $inscription->delete();

        return redirect()->back()->with('success', 'Participant retiré avec succès de la formation.');
    }
}