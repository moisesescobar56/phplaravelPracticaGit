<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('docente')->insert([
            'nombre' => 'admin',
            'apellido' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        DB::table('estudiante')->insert([
            'nombre' => 'juan',
            'apellido' => 'perez',
            'email' => 'JP2024001@esfe.agape.edu.sv',
            'pin' => Hash::make('XJP2024001'),
        ]);
        DB::table('grupo')->insert([
            'nombre' => '4G3',
            'descripcion' => 'Grupo de la tarde -  Thomas Jefferson',
        ]);
        DB::table('docente_grupo')->insert([
            'docente_id' => 1,
            'grupo_id' => 1
        ]);
        DB::table('estudiante_grupo')->insert([
            'estudiante_id' => 1,
            'grupo_id' => 1
        ]);
    }
}
