<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ObraSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('obrasocial')->insert([
        	'nombre' => 'APROSS',
            'tipo_obra' => 'Nacional',
        	'cuit' => 1122334455,
        	'telefono' => 1167455471,
        	'ciudad' => 'Ciudad '.Str::random(20),
        	'direccion' => 'Direccion '.Str::random(20),
        	'email' => Str::random(15).'@gmail.com',
        	'condicion_iva' => 'Responsable Inscripto',
        	'valor_sesion' => rand(5,300),
        	'valor_km' => rand(5,15),
        	'valor_modulo' => rand(5,500),
        	'valor_mes' => rand(500, 1500)
        ]);
    }
}
