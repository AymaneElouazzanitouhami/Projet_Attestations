<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Etudiant;

class StudentAuthController extends Controller
{
    /**
     * Gère la tentative d'identification de l'étudiant.
     */
    public function login(Request $request)
    {
        // 1. Définir les règles de validation
        $rules = [
            'email' => ['required', 'email', 'ends_with:@etu.uae.ac.ma', 'max:255'],
            'numero_apogee' => ['required', 'string', 'min:1', 'max:50'],
            'cin' => ['required', 'string', 'min:1', 'max:20'],
        ];

        // 2. Définir les messages d'erreur personnalisés
        $messages = [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.ends_with' => 'L\'adresse email doit être une adresse institutionnelle (@etu.uae.ac.ma).',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'numero_apogee.required' => 'Le numéro Apogée est obligatoire.',
            'numero_apogee.min' => 'Le numéro Apogée est invalide.',
            'numero_apogee.max' => 'Le numéro Apogée ne peut pas dépasser 50 caractères.',
            'cin.required' => 'Le CIN est obligatoire.',
            'cin.min' => 'Le CIN est invalide.',
            'cin.max' => 'Le CIN ne peut pas dépasser 20 caractères.',
            'required' => 'Le champ :attribute est obligatoire.'
        ];

        // 3. Valider les données
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/#contact')
                ->withErrors($validator)
                ->withInput();
        }

        // 4. CORRECTION : On nettoie les entrées pour enlever les espaces accidentels avant la recherche
        $email = trim($request->input('email'));
        $numero_apogee = trim($request->input('numero_apogee'));
        $cin = trim($request->input('cin'));

        // 5. Rechercher l'étudiant avec les données nettoyées
        $etudiant = Etudiant::where('email', $email)
                            ->where('numero_apogee', $numero_apogee)
                            ->where('cin', $cin)
                            ->first();

        // 6. Gérer le succès ou l'échec
        if ($etudiant) {
            // Succès : Stocker en session et rediriger
            $request->session()->put('etudiant', $etudiant);
            return redirect()->route('choix.action');
        } else {
            // Échec : Rediriger avec une erreur
            return redirect('/#contact')
                ->withErrors(['identification' => 'Les informations fournies ne correspondent à aucun étudiant. Veuillez réessayer.'])
                ->withInput();
        }
    }

    /**
     * Déconnecte l'étudiant.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('etudiant');
        return redirect()->route('home')->with('success', 'Vous avez été déconnecté.');
    }
}

