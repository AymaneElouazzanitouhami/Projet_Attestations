<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    /**
     * Gère la tentative de connexion de l'administrateur.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // CORRECTION FINALE : On utilise 'password' comme clé.
        // C'est la méthode standard de Laravel. C'est le modèle qui fera le lien avec 'mot_de_passe'.
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // On tente de connecter l'administrateur avec la garde 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Échec de l'authentification
        return back()->withErrors([
            'identification' => 'Accès non autorisé. Cette zone est sensible, veuillez vérifier si vous êtes un administrateur autorisé.'
        ])->withInput();
    }

    /**
     * Gère la déconnexion de l'administrateur.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

