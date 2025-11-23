<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,formateur,participant'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle admin authorization code
        if ($request->role === 'admin' && $request->authCode !== 'admin123') {
            return back()->withErrors(['authCode' => 'Code d\'autorisation administrateur invalide'])->withInput();
        }

        $userData = [
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'est_actif' => $request->has('est_actif') ? true : false,
        ];

        // Add role-specific fields
        if ($request->role === 'participant') {
            $userData['pronoms'] = $request->pronoms;
            $userData['niveau'] = $request->niveau;
            $userData['preferences'] = $request->preferences ? json_encode($request->preferences) : null;
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('photos', 'public');
                $userData['photo'] = $path;
            }
        }

        if ($request->role === 'formateur') {
            $userData['specialite'] = $request->specialite;
            $userData['experience'] = $request->experience;
            
            // Handle CV upload
            if ($request->hasFile('cvPdf')) {
                $path = $request->file('cvPdf')->store('cvs', 'public');
                $userData['cv_path'] = $path;
            }
        }

        $user = User::create($userData);

        return redirect()->route('login')->with('success', 'Compte créé avec succès! Vous pouvez maintenant vous connecter.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            if (!$user->est_actif) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte est désactivé. Veuillez contacter l\'administrateur.']);
            }

            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo($user));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Déconnexion réussie');
    
    }

    private function redirectTo(User $user)
    {
        if ($user->isAdmin()) return '/admin/dashboard';
        if ($user->isFormateur()) return '/formateur/dashboard';
        return '/participant/dashboard';
    }
}