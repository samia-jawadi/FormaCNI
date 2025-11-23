<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Charger les counts manuellement si nécessaire
        $user->formations_count = $user->formations()->count();
        
        // Rediriger selon le rôle de l'utilisateur
        if ($user->role === 'admin') {
            return view('admin.profile.show', compact('user'));
        } elseif ($user->role === 'formateur') {
            return view('formateur.profile', compact('user'));
        } else {
            // Participant
            return view('participant.profile', compact('user'));
        }
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validation différente pour les administrateurs
        if ($user->role === 'admin') {
            $request->validate([
                'nom' => 'required|string|max:255',
                'adresse' => 'nullable|string|max:500',
            ]);
            
            $userData = [
                'nom' => $request->nom,
                'adresse' => $request->adresse,
            ];
        } else {
            $validationRules = [
                'nom' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ];
            
            // Add photo validation for participants
            if ($user->isParticipant()) {
                $validationRules['photo'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
            
            $request->validate($validationRules);

            $userData = [
                'nom' => $request->nom,
                'email' => $request->email,
            ];
        }

        // Mettre à jour les champs spécifiques au rôle
        if ($user->isParticipant()) {
            $userData['pronoms'] = $request->pronoms;
            $userData['niveau'] = $request->niveau;
            $userData['adresse'] = $request->adresse;
            
            // Handle photo removal
            if ($request->has('remove_photo')) {
                if ($user->photo) {
                    \Storage::disk('public')->delete($user->photo);
                }
                $userData['photo'] = null;
            }
            // Handle photo upload
            elseif ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($user->photo) {
                    \Storage::disk('public')->delete($user->photo);
                }
                // Store new photo
                $path = $request->file('photo')->store('photos', 'public');
                $userData['photo'] = $path;
            }
            else {
                // Preserve existing photo by explicitly setting it
                $userData['photo'] = $user->photo;
            }
        } elseif ($user->isFormateur()) {
            $userData['specialite'] = $request->specialite;
            $userData['experience'] = $request->experience;
            $userData['bio'] = $request->bio;
            $userData['email'] = $request->email;
            $userData['prenom'] = $request->prenom;
            $userData['telephone'] = $request->telephone;
            $userData['adresse'] = $request->adresse;

            // Handle CV file upload if provided
            if ($request->hasFile('cv')) {
                // Delete old CV if exists
                if ($user->cv_path) {
                    \Storage::disk('public')->delete($user->cv_path);
                }
                $cvPath = $request->file('cv')->store('cvs', 'public');
                $userData['cv_path'] = $cvPath;
            } elseif ($request->filled('cv_path')) {
                // If a direct path provided (fallback)
                $userData['cv_path'] = $request->cv_path;
            }
        }

        $user->update($userData);

        return back()->with('success', 'Profil mis à jour avec succès!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success_password', 'Mot de passe modifié avec succès!');
    }

    public function delete(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Empêcher la suppression du compte administrateur principal
        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Les comptes administrateurs ne peuvent pas être supprimés.']);
        }
        
        // Pour les participants et formateurs, désactiver le compte au lieu de le supprimer
        if ($user->role === 'participant' || $user->role === 'formateur') {
            // Marquer le compte comme inactif
            $user->update([
                'est_actif' => false,
                'deactivated_at' => now(),
                'email' => $user->email . '_deactivated_' . time() // Éviter les conflits d'email
            ]);
            
            // Log the deactivation for admin reference
            \Log::info('User account deactivated (soft delete):', [
                'user_id' => $user->id,
                'nom' => $user->nom,
                'email' => $user->email,
                'role' => $user->role,
                'deactivated_at' => now()
            ]);
        } else {
            // Pour d'autres rôles, supprimer réellement (si nécessaire)
            $user->delete();
        }
        
        // Déconnecter l'utilisateur
        Auth::logout();
        
        // Invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Rediriger vers la page d'accueil avec un message
        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }
}
