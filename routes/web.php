<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your FormaCNI application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// ===========================================
// PUBLIC ROUTES
// ===========================================

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ===========================================
// AUTHENTICATION ROUTES
// ===========================================

// Guest routes (for non-authenticated users)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Logout route (available for authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===========================================
// AUTHENTICATED ROUTES
// ===========================================

Route::middleware(['auth', 'check.active'])->group(function () {
    
    // Main dashboard redirect
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isFormateur()) {
            return redirect()->route('formateur.dashboard');
        } else {
            return redirect()->route('participant.dashboard');
        }
    })->name('dashboard');

    // ===========================================
    // PROFILE ROUTES
    // ===========================================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::delete('/', [ProfileController::class, 'delete'])->name('delete');
    });

    // ===========================================
    // FORMATION ROUTES (Common to all authenticated users)
    // ===========================================
    Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
    Route::get('/formations/{formation}', [FormationController::class, 'show'])->name('formations.show');
    
    // ===========================================
    // PARTICIPANT ROUTES
    // ===========================================
    Route::prefix('participant')->name('participant.')->group(function () {
        Route::get('/dashboard', function () {
            /** @var \App\Models\User $user */
            $user = auth()->user();
            if (!$user->isParticipant()) {
                abort(403, 'Accès réservé aux participants');
            }
            
            $formationsInscrites = $user->formationsInscrites()->take(5)->get();
            
            return view('participant.dashboard', compact('formationsInscrites'));
        })->name('dashboard');
        
        // Additional participant routes
        Route::get('/mes-formations', [InscriptionController::class, 'mesFormations'])->name('formations');
        Route::get('/mes-inscriptions', [InscriptionController::class, 'mesInscriptions'])->name('inscriptions');
    });

    // ===========================================
    // INSCRIPTION ROUTES (Participants only)
    // ===========================================
    Route::post('/formations/{formation}/inscrire', [InscriptionController::class, 'store'])->name('inscriptions.store');

    // ===========================================
    // FORMATEUR ROUTES
    // ===========================================
    Route::prefix('formateur')->name('formateur.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [FormateurController::class, 'dashboard'])->name('dashboard');

        // Formation management for formateurs
        Route::get('/formations/create', [FormationController::class, 'create'])->name('formations.create');
        Route::post('/formations', [FormationController::class, 'store'])->name('formations.store');
        Route::get('/formations/{formation}/edit', [FormationController::class, 'edit'])->name('formations.edit');
        Route::put('/formations/{formation}', [FormationController::class, 'update'])->name('formations.update');
        Route::post('/formations/{formation}/terminate', [FormationController::class, 'terminate'])->name('formations.terminate');
        Route::get('/mes-formations', [FormateurController::class, 'myFormations'])->name('formations.index');

        // Demande management for formateurs
        Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
        Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
        Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
        Route::get('/demandes/{demande}', [DemandeController::class, 'show'])->name('demandes.show');

        // Formateur profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

        // Formation details for formateurs
        Route::get('/formations/{formation}', [FormateurController::class, 'showFormation'])->name('formations.show');

        // Participant management
        Route::post('/formations/{formation}/participants/{participant}/remove', [FormateurController::class, 'removeParticipant'])->name('formations.participants.remove');
    });

    // ===========================================
    // ADMIN ROUTES
    // ===========================================
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Admin Dashboard
        Route::get('/dashboard', function() {
            /** @var \App\Models\User $user */
            $user = auth()->user();
            if (!$user->isAdmin()) {
                abort(403, 'Accès réservé aux administrateurs');
            }
            return app(AdminController::class)->dashboard();
        })->name('dashboard');
        
        // User Management
        Route::prefix('users')->name('users.')->controller(AdminController::class)->group(function () {
            Route::get('/', 'users')->name('index');
            Route::get('/create', 'createUser')->name('create');
            Route::get('/test-create', function() { 
                if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
                return view('admin.users.test-create'); 
            })->name('test-create');
            Route::post('/', 'storeUser')->name('store');
            Route::get('/inactive/list', 'inactiveUsers')->name('inactive');

            // Convenience routes: /admin/users/show?id=... and /admin/users/modifie?id=...
            Route::get('/show', function() {
                if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
                $id = request()->query('id');
                if (!$id) {
                    return redirect()->route('admin.users.index')->withErrors(['error' => 'Paramètre id requis']);
                }
                $user = \App\Models\User::findOrFail($id);
                return app(\App\Http\Controllers\AdminController::class)->showUser($user);
            })->name('show.byId');
            Route::get('/modifie', function() {
                if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
                $id = request()->query('id');
                if (!$id) {
                    return redirect()->route('admin.users.index')->withErrors(['error' => 'Paramètre id requis']);
                }
                $user = \App\Models\User::findOrFail($id);
                return app(\App\Http\Controllers\AdminController::class)->editUser($user);
            })->name('edit.byId');

            Route::get('/{user}', 'showUser')->name('show');
            Route::get('/{user}/edit', 'editUser')->name('edit');
            Route::put('/{user}', 'updateUser')->name('update');
            Route::delete('/{user}', 'destroyUser')->name('destroy');
            Route::post('/{user}/toggle-status', 'toggleUserStatus')->name('toggle-status');
        });
        
        // Formateur Management
        Route::get('/formateurs', function() {
            if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
            return app(AdminController::class)->formateurs();
        })->name('formateurs');
        
        // Participant Management
        Route::get('/participants', function() {
            if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
            return app(AdminController::class)->participants(request());
        })->name('participants');
        
        // Formation Management (Admin view)
        Route::prefix('formations')->name('formations.')->group(function () {
            Route::get('/', [AdminController::class, 'formations'])->name('index');
            Route::get('/{formation}', [AdminController::class, 'showFormation'])->name('show');
            Route::get('/{formation}/edit', [AdminController::class, 'editFormation'])->name('edit');
            Route::put('/{formation}', [AdminController::class, 'updateFormation'])->name('update');
            Route::delete('/{formation}', [AdminController::class, 'destroyFormation'])->name('destroy');
            Route::post('/{formation}/approve', [AdminController::class, 'approveFormation'])->name('approve');
            Route::post('/{formation}/reject', [AdminController::class, 'rejectFormation'])->name('reject');
            Route::post('/{formation}/terminate', [AdminController::class, 'terminateFormation'])->name('terminate');
        });
        
        // Demande Management (Admin view)
        Route::prefix('demandes')->name('demandes.')->group(function () {
            Route::get('/', [AdminController::class, 'demandes'])->name('index');
            Route::get('/{demande}', [AdminController::class, 'showDemande'])->name('show');
            Route::post('/{demande}/accept', [AdminController::class, 'acceptDemande'])->name('accept');
            Route::post('/{demande}/reject', [AdminController::class, 'rejectDemande'])->name('reject');
        });
        
        // Inscription Management
        Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
            Route::get('/', [AdminController::class, 'inscriptions'])->name('index');
            Route::post('/{inscription}/approve', [AdminController::class, 'approveInscription'])->name('approve');
            Route::post('/{inscription}/reject', [AdminController::class, 'rejectInscription'])->name('reject');
        });
        
        // Analytics & Reports
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        
        // System Settings
        Route::get('/settings', function() {
            if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
            return app(AdminController::class)->settings();
        })->name('settings');
        Route::put('/settings', function() {
            if (!auth()->user()->isAdmin()) abort(403, 'Accès réservé aux administrateurs');
            return app(AdminController::class)->updateSettings(request());
        })->name('settings.update');
    }); // End admin routes group
});
