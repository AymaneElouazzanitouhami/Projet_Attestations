<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtudiantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('etudiants')->insert([
            [
                'id_etudiant' => 1,
                'nom' => 'Alaoui',
                'prenom' => 'Fatima',
                'email' => 'fatima.alaoui@etu.uae.ac.ma',
                'cin' => 'G123456',
                'numero_apogee' => '18001234',
                'niveau_actuel' => 5,
                'filiere_actuelle' => 'Génie Informatique',
                'statut_inscription' => 'inscrit',
                'parcours_sans_redoublement' => 1,
                'created_at' => '2025-11-18 17:38:26',
                'updated_at' => '2025-11-18 17:38:26',
            ],
            [
                'id_etudiant' => 2,
                'nom' => 'Bennani',
                'prenom' => 'Youssef',
                'email' => 'youssef.bennani@etu.uae.ac.ma',
                'cin' => 'H789012',
                'numero_apogee' => '19005678',
                'niveau_actuel' => 4,
                'filiere_actuelle' => 'Génie Civil',
                'statut_inscription' => 'inscrit',
                'parcours_sans_redoublement' => 0,
                'created_at' => '2025-11-18 17:38:26',
                'updated_at' => '2025-11-18 17:38:26',
            ],
            [
                'id_etudiant' => 3,
                'nom' => 'Chafik',
                'prenom' => 'Amina',
                'email' => 'amina.chafik@etu.uae.ac.ma',
                'cin' => 'K345678',
                'numero_apogee' => '20009012',
                'niveau_actuel' => 2,
                'filiere_actuelle' => null,
                'statut_inscription' => 'inscrit',
                'parcours_sans_redoublement' => 1,
                'created_at' => '2025-11-18 17:38:26',
                'updated_at' => '2025-11-18 17:38:26',
            ],
            [
                'id_etudiant' => 4,
                'nom' => 'Drissi',
                'prenom' => 'Mehdi',
                'email' => 'mehdi.drissi@etu.uae.ac.ma',
                'cin' => 'L901234',
                'numero_apogee' => '17003456',
                'niveau_actuel' => 5,
                'filiere_actuelle' => 'Génie Mécatronique',
                'statut_inscription' => 'non_inscrit',
                'parcours_sans_redoublement' => 1,
                'created_at' => '2025-11-18 17:38:26',
                'updated_at' => '2025-11-18 17:38:26',
            ],
            [
                'id_etudiant' => 5,
                'nom' => 'El Fassi',
                'prenom' => 'Salma',
                'email' => 'salma.elfassi@etu.uae.ac.ma',
                'cin' => 'M567890',
                'numero_apogee' => '21007890',
                'niveau_actuel' => 1,
                'filiere_actuelle' => null,
                'statut_inscription' => 'inscrit',
                'parcours_sans_redoublement' => 1,
                'created_at' => '2025-11-18 17:38:26',
                'updated_at' => '2025-11-18 17:38:26',
            ],
        ]);
    }
}
