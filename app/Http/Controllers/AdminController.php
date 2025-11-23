<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use App\Models\Demande;
use App\Models\Inscription;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user->isAdmin()) {
                abort(403, 'Accès non autorisé.');
            }

            return $next($request);
        });
    }
public function dashboard()
{
    // Participants Statistics
    $totalParticipants = User::where('role', 'participant')->count();
    $newParticipantsThisMonth = User::where('role', 'participant')
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();


    // Formations en Cours (actually running + upcoming active formations)
    $formationsEnCours = Formation::where('statut', 'ACTIVE')
        ->where('date_fin', '>=', now()) // Not yet ended
        ->count();

    // Participants actifs
    $participantsActifs = 0;
    $currentFormations = Formation::where('statut', 'ACTIVE')
        ->where('date_debut', '<=', now())
        ->where('date_fin', '>=', now())
        ->get();
    
    foreach ($currentFormations as $formation) {
        $participantsActifs += $formation->inscriptions()
            ->where('statut', 'CONFIRMEE')
            ->count();
    }

    // AJOUTEZ CES VARIABLES ICI :
    // Formations en attente de validation
    $formationsEnAttente = Formation::where('statut', 'ATTENTE_VALIDATION')->count();
    
    // Demandes en attente
    $demandesEnAttente = Demande::where('statut', 'EN_ATTENTE')->count();
    
    // Validations en Attente - COMBINAISON des demandes ET formations en attente
    $validationsEnAttente = $demandesEnAttente + $formationsEnAttente;

    // Pending Formations for display
    $pendingFormations = Formation::where('statut', 'ATTENTE_VALIDATION')
        ->with('formateur')
        ->latest()
        ->take(6)
        ->get();

    // Pending Demandes for display - AJOUTEZ CELLE-CI AUSSI
    $pendingDemandes = Demande::where('statut', 'EN_ATTENTE')
        ->with('formateur')
        ->latest()
        ->take(6)
        ->get();

    $recentActivities = $this->getRecentActivities();

    return view('admin.tableau-de-bord', compact(
        'totalParticipants',
        'formationsEnCours',
        'participantsActifs',
        'validationsEnAttente',
        'demandesEnAttente',
        'formationsEnAttente',
        'newParticipantsThisMonth',
        'pendingFormations',
        'pendingDemandes',
        'recentActivities'
    ));
}
    // User Management Methods
 public function users(Request $request)
{
    $query = User::withCount(['formations', 'inscriptions']);

    // Appliquer les filtres
    if ($request->has('search') && $request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nom', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('role') && $request->role) {
        $query->where('role', $request->role);
    }

    // Filtre par statut
    if ($request->has('status') && $request->status) {
        if ($request->status === 'active') {
            $query->where('est_actif', true);
        } elseif ($request->status === 'inactive') {
            $query->where('est_actif', false);
        }
    }
    // Si pas de filtre de statut, montrer tous les utilisateurs

    $users = $query->latest()->paginate(10);

    $userStats = [
        'total' => User::count(),
        'admins' => User::where('role', 'admin')->count(),
        'formateurs' => User::where('role', 'formateur')->count(),
        'participants' => User::where('role', 'participant')->count(),
        'active' => User::where('est_actif', true)->count(),
        'inactive' => User::where('est_actif', false)->count()
    ];

    return view('admin.gestion-utilisateurs', compact('users', 'userStats'));
}

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
{
    // Log all incoming request data for debugging
    \Log::info('User creation request received', [
        'all_data' => $request->all(),
        'method' => $request->method(),
        'url' => $request->url()
    ]);
    
    try {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,formateur,participant',
            'est_actif' => 'required|boolean',
        ]);
        
        \Log::info('Validation passed');

        // Créer l'utilisateur avec les informations de base uniquement
        $userData = [
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'est_actif' => (bool) $request->est_actif,
        ];

        // Ajouter les valeurs par défaut selon le rôle
        switch ($request->role) {
            case 'participant':
                $userData['niveau'] = 'débutant'; // Valeur par défaut
                $userData['pronoms'] = null;
                $userData['preferences'] = null;
                break;
                
            case 'formateur':
                $userData['specialite'] = 'À compléter'; // Valeur par défaut
                $userData['experience'] = 0; // Valeur par défaut
                $userData['cv_path'] = null;
                break;
                
            case 'admin':
                // Pas de champs supplémentaires requis pour admin
                break;
        }
        
        \Log::info('User data prepared', ['user_data' => array_merge($userData, ['password' => '[HIDDEN]'])]);

        $user = User::create($userData);
        
        \Log::info('User created successfully', ['user_id' => $user->id, 'user_email' => $user->email]);

        return redirect()->route('admin.users.index')->with('success', 
            'Utilisateur créé avec succès! Les informations spécifiques au rôle peuvent être complétées via "Modifier".');
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed', ['errors' => $e->errors()]);
        return back()->withErrors($e->errors())->withInput();
        
    } catch (\Exception $e) {
        \Log::error('User creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Erreur lors de la création de l\'utilisateur: ' . $e->getMessage())->withInput();
    }
}

   public function editUser(User $user)
{
    // Charger les counts pour les statistiques
    $user->loadCount(['formations', 'inscriptions']);
    
    return view('admin.users.edit', compact('user'));
}
    public function updateUser(Request $request, User $user)
    {
        // Prevent an admin from deactivating their own account
        if ($user->id === auth()->user()->id && !$request->boolean('est_actif')) {
            return back()->withErrors(['error' => "Vous ne pouvez pas désactiver votre propre compte administrateur."])->withInput();
        }

        $validationRules = [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,formateur,participant',
            'password' => 'nullable|string|min:6|confirmed',
            'est_actif' => 'required|boolean',
            'est_stagiere' => 'required|boolean'
        ];
    
    // Add photo validation for participants
    if ($request->role === 'participant') {
        $validationRules['photo'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
    }
    
    $request->validate($validationRules);

    $userData = [
        'nom' => $request->nom,
        'email' => $request->email,
        'role' => $request->role,
        'est_actif' => $request->est_actif,
    ];

    // Mettre à jour le mot de passe si fourni
    if ($request->filled('password')) {
        $userData['password'] = Hash::make($request->password);
    }

    // Gérer les champs spécifiques au rôle
    if ($request->role === 'participant') {
        $userData['pronoms'] = $request->pronoms;
        $userData['niveau'] = $request->niveau;
        $userData['adresse'] = $request->adresse;
        $userData['preferences'] = $request->preferences ? json_encode($request->preferences) : null;
        
        // Handle photo removal
        if ($request->has('remove_photo')) {
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            $userData['photo'] = null;
        }
        // Handle photo upload
        elseif ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            // Store new photo
            $path = $request->file('photo')->store('photos', 'public');
            $userData['photo'] = $path;
        }
        
        // Effacer les champs formateur
        $userData['specialite'] = null;
        $userData['experience'] = null;
        $userData['cv_path'] = null;
    } elseif ($request->role === 'formateur') {
        $userData['specialite'] = $request->specialite;
        $userData['experience'] = $request->experience;
        $userData['cv_path'] = $request->cv_path;
        // Effacer les champs participant
        $userData['pronoms'] = null;
        $userData['niveau'] = null;
        $userData['preferences'] = null;
    } else {
        // Admin - effacer tous les champs spécifiques
        $userData['pronoms'] = null;
        $userData['niveau'] = null;
        $userData['preferences'] = null;
        $userData['specialite'] = null;
        $userData['experience'] = null;
        $userData['cv_path'] = null;
    }

    $user->update($userData);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur modifié avec succès!');
}

    public function toggleUserStatus(User $user)
    {
        // Block self-deactivation for admins (and any user)
        if ($user->id === auth()->id() && $user->est_actif && $user->isAdmin()) {
            return back()->withErrors(['error' => "Vous ne pouvez pas désactiver votre propre compte administrateur."]);
        }

        if ($user->deactivated_at) {
            // Réactiver un compte supprimé (désactivé)
            $user->update([
                'est_actif' => true,
                'deactivated_at' => null,
                'email' => preg_replace('/_deactivated_\d+$/', '', $user->email) // Restaurer l'email original
            ]);
            $message = 'Compte réactivé avec succès!';
        } else {
            // Basculer le statut normal
            $user->update(['est_actif' => !$user->est_actif]);
            $message = $user->est_actif ? 'Utilisateur activé avec succès!' : 'Utilisateur désactivé avec succès!';
        }
        
        return redirect()->back()->with('success', $message);
    }

    public function inactiveUsers()
    {
        $users = User::where('est_actif', false)->latest()->get();
        return view('admin.users.inactive', compact('users'));
    }

    // Formation Management Methods
    public function formations()
    {
        $formations = Formation::with('formateur')
            ->withCount('inscriptions')
            ->withCount(['inscriptions as confirmed_inscriptions_count' => function($query) {
                $query->where('statut', 'CONFIRMEE');
            }])
            ->latest()
            ->get();

        $stats = [
            'total' => Formation::count(),
            'active' => Formation::where('statut', 'ACTIVE')->count(),
            'pending' => Formation::where('statut', 'ATTENTE_VALIDATION')->count(),
            'completed' => Formation::where('terminee', true)->count(),
            'upcoming' => Formation::where('statut', 'ACTIVE')
                         ->where('date_debut', '>', Carbon::now())->count(),
        ];

        return view('admin.formations', compact('formations', 'stats'));
    }

    public function editFormation(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function updateFormation(Request $request, Formation $formation)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'heure_debut' => 'required',
            'capacite_max' => 'required|integer|min:1',
            'statut' => 'required|in:ACTIVE,ATTENTE_VALIDATION'
        ]);

        $formation->update($request->all());

        return redirect()->route('admin.formations.index')->with('success', 'Formation modifiée avec succès!');
    }

    public function destroyFormation(Formation $formation)
    {
        // Désactiver ≙ Terminer: marquer comme terminée
        $formation->update(['terminee' => true]);

        // Notify formateur via Historique entry
        Historique::enregistrerAction(
            'MODIFICATION_FORMATION',
            'Formation terminée par un administrateur',
            $formation->id,
            $formation->formateur_id
        );

        return redirect()->route('admin.formations.index')->with('success', 'Formation terminée avec succès!');
    }

    public function terminateFormation(Formation $formation)
    {
        // Mark as completed using boolean column instead of enum value
        $formation->update(['terminee' => true]);
        
        // Notify formateur via Historique entry
        Historique::enregistrerAction(
            'MODIFICATION_FORMATION',
            'Formation terminée par un administrateur',
            $formation->id,
            $formation->formateur_id
        );
        
        return redirect()->route('admin.formations.index')->with('success', 'Formation terminée avec succès!');
    }


    // Demande Management Methods
    public function demandes()
    {
        $demandes = Demande::with('formateur')
            ->where('statut', 'EN_ATTENTE')
            ->latest()
            ->get();

        return view('admin.demandes', compact('demandes'));
    }

    public function acceptDemande(Demande $demande)
    {
        // Create formation from demande with ACTIVE status (directly usable)
        Formation::create([
            'titre' => $demande->titre,
            'description' => $demande->description,
            'duree' => $demande->duree_proposee ?? 8, // Default 8 hours if not specified
            'formateur_id' => $demande->formateur_id,
            'date_debut' => now()->addDays(7),
            'date_fin' => now()->addDays(7)->addHours($demande->duree_proposee ?? 8),
            'heure_debut' => '09:00:00',
            'capacite_max' => 20,
            'statut' => 'ACTIVE' // Direct active status - ready for inscriptions
        ]);

        // Mark demande as accepted
        $demande->update(['statut' => 'ACCEPTEE']);

        return redirect()->route('admin.demandes.index')->with('success', 'Demande acceptée et formation créée avec succès!');
    }


    public function rejectDemande(Request $request, Demande $demande)
    {
        $request->validate([
            'raison_refus' => 'required|string'
        ]);

        $demande->update([
            'statut' => 'REFUSEE',
            'raison_refus' => $request->raison_refus
        ]);

        return redirect()->route('admin.demandes.index')->with('success', 'Demande refusée!');
    }

 public function formateurs(Request $request)
{
    $query = User::where('role', 'formateur')
        ->withCount([
            'formations',
            'formations as active_formations_count' => function($query) {
                $query->where('statut', 'ACTIVE');
            },
            'formations as pending_formations_count' => function($query) {
                $query->where('statut', 'ATTENTE_VALIDATION');
            },
            'demandes as pending_demandes_count' => function($query) {
                $query->where('statut', 'EN_ATTENTE');
            }
        ]);

    // Appliquer les filtres
    if ($request->has('search') && $request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nom', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('specialite', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('status') && $request->status) {
        if ($request->status === 'active') {
            $query->where('est_actif', true);
        } elseif ($request->status === 'inactive') {
            $query->where('est_actif', false);
        }
    }

    if ($request->has('experience') && $request->experience) {
        switch ($request->experience) {
            case '0-2':
                $query->where('experience', '<=', 2);
                break;
            case '3-5':
                $query->whereBetween('experience', [3, 5]);
                break;
            case '5+':
                $query->where('experience', '>=', 5);
                break;
        }
    }

    $formateurs = $query->latest()->paginate(10);

    $stats = [
        'total' => User::where('role', 'formateur')->count(),
        'active' => User::where('role', 'formateur')->where('est_actif', true)->count(),
        'inactive' => User::where('role', 'formateur')->where('est_actif', false)->count(),
        'avg_experience' => round(User::where('role', 'formateur')->avg('experience') ?? 0, 1),
    ];

    return view('admin.formateurs', compact('formateurs', 'stats'));
}

public function participants(Request $request)
{
    $query = User::where('role', 'participant')
        ->withCount([
            'inscriptions',
            'inscriptions as confirmed_inscriptions_count' => function($query) {
                $query->where('statut', 'CONFIRMEE');
            },
            'inscriptions as pending_inscriptions_count' => function($query) {
                $query->where('statut', 'EN_ATTENTE');
            }
        ]);

    // Apply filters
    if ($request->has('search') && $request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nom', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('status') && $request->status) {
        if ($request->status === 'active') {
            $query->where('est_actif', true);
        } elseif ($request->status === 'inactive') {
            $query->where('est_actif', false)->whereNull('deactivated_at');
        } elseif ($request->status === 'deactivated') {
            $query->where('est_actif', false)->whereNotNull('deactivated_at');
        }
    }

    if ($request->has('niveau') && $request->niveau) {
        $query->where('niveau', $request->niveau);
    }

    $participants = $query->latest()->paginate(10);

    $stats = [
        'total' => User::where('role', 'participant')->count(),
        'active' => User::where('role', 'participant')->where('est_actif', true)->count(),
        'inactive' => User::where('role', 'participant')->where('est_actif', false)->count(),
        'deactivated' => User::where('role', 'participant')->where('est_actif', false)->whereNotNull('deactivated_at')->count(),
        'with_photos' => User::where('role', 'participant')->whereNotNull('photo')->count(),
        'debutant' => User::where('role', 'participant')->where('niveau', 'debutant')->count(),
        'intermediaire' => User::where('role', 'participant')->where('niveau', 'intermediaire')->count(),
        'avance' => User::where('role', 'participant')->where('niveau', 'avance')->count(),
    ];

    return view('admin.participants', compact('participants', 'stats'));
}
    public function analytics()
    {
        $userGrowth = $this->getUserGrowthData();
        $formationStats = $this->getFormationStats();
        $platformPerformance = $this->getPlatformPerformance();
        $completionRates = $this->getCompletionRates();
        
        // Additional stats for the view
        $userStats = [
            'total' => User::count(),
            'participants' => User::where('role', 'participant')->count(),
            'formateurs' => User::where('role', 'formateur')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'inactive' => User::where('est_actif', false)->count(),
            // Active participants: participants with est_actif = true
            'active_participants' => User::where('role', 'participant')->where('est_actif', true)->count(),
            // "Certified" formateurs proxy: formateurs with a CV uploaded
            'certified_formateurs' => User::where('role', 'formateur')->whereNotNull('cv_path')->count(),
        ];
        
        $inscriptionStats = [
            'total' => Inscription::count(),
            'active' => Inscription::where('statut', 'CONFIRMEE')->count(),
            'pending' => Inscription::where('statut', 'EN_ATTENTE')->count(),
        ];

        return view('admin.analytiques', compact(
            'userGrowth', 
            'formationStats', 
            'platformPerformance',
            'completionRates',
            'userStats',
            'inscriptionStats'
        ));
    }

    public function settings()
    {
        return view('admin.parametres');
    }

    public function updateSettings(Request $request)
    {
        // This method would handle system settings updates
        // For now, just redirect back with success message
        return redirect()->route('admin.settings')->with('success', 'Paramètres mis à jour avec succès!');
    }

    // Additional User Management Methods
    public function showUser(User $user)
    {
        $user->loadCount(['formations', 'inscriptions']);
        return view('admin.users.show', compact('user'));
    }

    public function destroyUser(User $user)
    {
        // Prevent deletion of current admin
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte']);
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }

    // Additional Formation Management Methods
    public function showFormation(Formation $formation)
    {
        $formation->loadCount(['participants', 'inscriptions']);
        $formation->load(['formateur', 'participants']);
        return view('admin.formations.show', compact('formation'));
    }

    public function approveFormation(Formation $formation)
    {
        $formation->update(['statut' => 'ACTIVE']);
        return back()->with('success', 'Formation approuvée avec succès!');
    }

    public function rejectFormation(Request $request, Formation $formation)
    {
        $formation->update(['statut' => 'REFUSEE']);
        return back()->with('success', 'Formation refusée!');
    }

    // Additional Demande Management Methods
    public function showDemande(Demande $demande)
    {
        $demande->load('formateur');
        return view('admin.demandes.show', compact('demande'));
    }

    // Inscription Management Methods
    public function inscriptions()
    {
        $inscriptions = Inscription::with(['participant', 'formation', 'formation.formateur'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Inscription::count(),
            'en_attente' => Inscription::where('statut', 'EN_ATTENTE')->count(),
            'confirmees' => Inscription::where('statut', 'CONFIRMEE')->count(),
            'refusees' => Inscription::where('statut', 'REFUSEE')->count(),
        ];

        return view('admin.inscriptions', compact('inscriptions', 'stats'));
    }

    public function approveInscription(Inscription $inscription)
    {
        $inscription->update(['statut' => 'CONFIRMEE']);
        return back()->with('success', 'Inscription approuvée avec succès!');
    }

    public function rejectInscription(Inscription $inscription)
    {
        $inscription->update(['statut' => 'REFUSEE']);
        return back()->with('success', 'Inscription refusée!');
    }

    // Reports Method
    public function reports()
    {
        $monthlyUserRegistrations = $this->getMonthlyUserRegistrations();
        $formationPopularity = $this->getFormationPopularity();
        $formateurPerformance = $this->getFormateurPerformance();
        
        return view('admin.reports', compact(
            'monthlyUserRegistrations',
            'formationPopularity',
            'formateurPerformance'
        ));
    }

    // Helper methods for reports
    private function getMonthlyUserRegistrations()
    {
        return User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getFormationPopularity()
    {
        return Formation::withCount('inscriptions')
            ->orderBy('inscriptions_count', 'desc')
            ->take(10)
            ->get();
    }

    private function getFormateurPerformance()
    {
        return User::where('role', 'formateur')
            ->withCount(['formations', 'formations as active_formations_count' => function($query) {
                $query->where('statut', 'ACTIVE');
            }])
            ->having('formations_count', '>', 0)
            ->orderBy('active_formations_count', 'desc')
            ->take(10)
            ->get();
    }

    // Helper Methods
  private function getRecentActivities()
{
    $activities = [];
    $now = now();

    // Recent users (last 3)
    $recentUsers = User::latest()->take(3)->get();
    foreach ($recentUsers as $user) {
        $timeDiff = $now->diffInMinutes($user->created_at);
        $timeText = $this->formatPreciseTime($user->created_at, $now);
        
        $activities[] = [
            'type' => 'user',
            'icon' => 'fas fa-user-plus',
            'color' => 'text-blue-600',
            'bg' => 'bg-blue-50',
            'message' => "Nouvel utilisateur {$user->role}: {$user->nom}",
            'details' => "Email: {$user->email}",
            'timestamp' => $user->created_at,
            'time' => $timeText,
            'priority' => $timeDiff < 60 ? 1 : 2 // Recent activities get higher priority
        ];
    }

    // Recent formations (last 2)
    $recentFormations = Formation::with('formateur')->latest()->take(2)->get();
    foreach ($recentFormations as $formation) {
        $timeText = $this->formatPreciseTime($formation->created_at, $now);
        
        $activities[] = [
            'type' => 'formation',
            'icon' => 'fas fa-chalkboard-teacher',
            'color' => 'text-green-600',
            'bg' => 'bg-green-50',
            'message' => "Formation créée: {$formation->titre}",
            'details' => "Par: {$formation->formateur->nom} - Durée: {$formation->duree}h",
            'timestamp' => $formation->created_at,
            'time' => $timeText,
            'priority' => 3
        ];
    }

    // Recent inscriptions (last 2)
    $recentInscriptions = Inscription::with(['participant', 'formation'])
        ->latest()
        ->take(2)
        ->get();
    foreach ($recentInscriptions as $inscription) {
        $timeText = $this->formatPreciseTime($inscription->created_at, $now);
        
        $activities[] = [
            'type' => 'inscription',
            'icon' => 'fas fa-clipboard-list',
            'color' => 'text-purple-600',
            'bg' => 'bg-purple-50',
            'message' => "Nouvelle inscription: {$inscription->participant->nom}",
            'details' => "Formation: {$inscription->formation->titre}",
            'timestamp' => $inscription->created_at,
            'time' => $timeText,
            'priority' => 2
        ];
    }

    // Recent demands (last 2)
    $recentDemands = Demande::with('formateur')
        ->latest()
        ->take(2)
        ->get();
    foreach ($recentDemands as $demand) {
        $timeText = $this->formatPreciseTime($demand->created_at, $now);
        
        $activities[] = [
            'type' => 'demande',
            'icon' => 'fas fa-paper-plane',
            'color' => 'text-orange-600',
            'bg' => 'bg-orange-50',
            'message' => "Demande de formation: {$demand->titre}",
            'details' => "Par: {$demand->formateur->nom} - Durée proposée: {$demand->duree_proposee}h",
            'timestamp' => $demand->created_at,
            'time' => $timeText,
            'priority' => 3
        ];
    }

    // Sort by priority first, then by timestamp (most recent first)
    usort($activities, function($a, $b) {
        if ($a['priority'] === $b['priority']) {
            return $b['timestamp'] <=> $a['timestamp'];
        }
        return $a['priority'] <=> $b['priority'];
    });

    return array_slice($activities, 0, 6); // Show 6 most recent activities
}

/**
 * Format precise time difference
 */
private function formatPreciseTime($timestamp, $now)
{
    $diffInMinutes = $now->diffInMinutes($timestamp);
    $diffInHours = $now->diffInHours($timestamp);
    $diffInDays = $now->diffInDays($timestamp);
    
    if ($diffInMinutes < 1) {
        return "Il y a moins d'une minute";
    } elseif ($diffInMinutes < 60) {
        return "Il y a {$diffInMinutes} minute" . ($diffInMinutes > 1 ? 's' : '');
    } elseif ($diffInHours < 24) {
        $remainingMinutes = $diffInMinutes % 60;
        if ($remainingMinutes > 0 && $diffInHours < 6) {
            return "Il y a {$diffInHours}h{$remainingMinutes}m";
        }
        return "Il y a {$diffInHours} heure" . ($diffInHours > 1 ? 's' : '');
    } elseif ($diffInDays < 7) {
        $remainingHours = $diffInHours % 24;
        if ($remainingHours > 0 && $diffInDays < 3) {
            return "Il y a {$diffInDays}j {$remainingHours}h";
        }
        return "Il y a {$diffInDays} jour" . ($diffInDays > 1 ? 's' : '');
    } else {
        return $timestamp->format('d/m/Y à H:i');
    }
}
private function calculateFormationCompletionRate()
{
    // Calculate completion rate based on formations that have ended
    $totalFormations = Formation::count();
    
    if ($totalFormations === 0) {
        return 0;
    }
    
    // Count completed formations (those that have ended and have participants)
    $completedFormations = Formation::where('date_fin', '<', now())
        ->whereHas('inscriptions', function($query) {
            $query->where('statut', 'CONFIRMEE');
        })
        ->count();
    
    return $totalFormations > 0 ? round(($completedFormations / $totalFormations) * 100) : 0;
}
    private function getUserGrowthData()
    {
        $data = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $data[] = $count;
            $labels[] = $month->format('M Y');
        }
        
        return [
            'data' => $data,
            'labels' => $labels
        ];
    }

    private function getFormationStats()
    {
        $formationsByStatus = Formation::selectRaw('statut, COUNT(*) as count')
            ->groupBy('statut')
            ->pluck('count', 'statut')
            ->toArray();

        return [
            'by_status' => $formationsByStatus,
            'total' => Formation::count(),
            'active' => Formation::where('statut', 'ACTIVE')->count(),
            'pending' => Formation::where('statut', 'ATTENTE_VALIDATION')->count(),
            'total_participants' => Inscription::count(),
            'completion_rate' => $this->calculateFormationCompletionRate()
        ];
    }

  private function calculateParticipationRate()
{
    $totalUsers = User::where('role', 'participant')->count();
    $activeParticipants = Inscription::distinct()->count('participant_id');
    
    return $totalUsers > 0 ? round(($activeParticipants / $totalUsers) * 100) : 0;
}


    private function getCompletionRates()
    {
        $rates = [
            'Développement Web' => 85,
            'Applications Mobiles' => 72,
            'Design & UX' => 68,
            'Data Science' => 91
        ];
        
        $average = round(array_sum($rates) / count($rates));
        $success = $this->calculateFormationCompletionRate();
        
        return [
            'rates' => $rates,
            'average' => $average,
            'success' => $success
        ];
    }

    private function getPlatformPerformance()
    {
        return [
            'uptime' => '99.9%',
            'response_time' => '142ms',
            'concurrent_users' => User::where('created_at', '>=', Carbon::now()->subDays(1))->count(), // Active users in last 24h
            'storage_used' => '45%',
            'participation_rate' => $this->calculateParticipationRate()
        ];
    }
    
}