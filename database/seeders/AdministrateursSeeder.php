<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministrateursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('administrateurs')->insert([
            [
                'id_admin' => 1,
                'nom_complet' => 'Admin Principal',
                'email' => 'admin@attesta.ma',
                'mot_de_passe' => '$2y$12$j7roxSFf3pSDNEYfdYJz9.J/tViR1nIpc6HnEwIAWAHnC.1wR6jPK',
                'remember_token' => null,
                'created_at' => '2025-11-18 17:38:26',
                'updated_at' => '2025-11-18 17:38:26',
            ],
        ]);
    }
}
