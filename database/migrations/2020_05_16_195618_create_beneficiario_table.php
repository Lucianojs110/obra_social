<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiario', function (Blueprint $table) {
            $table->id();
            $table->integer('prestador_id')->nullable();
            $table->integer('sesion_id')->nullable();
            $table->text('nombre', 75)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('telefono', 75)->nullable();
            $table->string('direccion', 75)->nullable();
            $table->string('localidad', 75)->nullable();
            $table->string('dni', 15)->nullable();
            $table->string('cuit', 45)->nullable();
            $table->string('direccion_prestacion', 50)->nullable();
            $table->string('localidad_prestacion', 50)->nullable();
            $table->integer('km_ida')->nullable();
            $table->integer('km_vuelta')->nullable();
            $table->integer('viajes_ida')->nullable();
            $table->integer('viajes_vuelta')->nullable();
            $table->string('turno', 20)->nullable();
            $table->string('dependencia', 50)->nullable();
            $table->string('notas')->nullable();
            $table->integer('numero_afiliado')->nullable();
            $table->integer('codigo_seguridad')->nullable();
            $table->integer('cantidad_solicitada')->nullable();
            $table->tinyInteger('activo', 1)->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiario');
    }
}
