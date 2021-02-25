<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObrasocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obrasocial', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 75)->nullable();
            $table->string('tipo_obra', 50)->nullable();
            $table->string('cuit', 45)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('ciudad', 65)->nullable();
            $table->string('direccion', 75)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('condicion_iva', 50)->nullable();
            $table->decimal('valor_sesion', 10, 2)->nullable();
            $table->decimal('valor_km', 10, 2)->nullable();
            $table->decimal('valor_modulo', 10, 2)->nullable();
            $table->string('valor_mes', 50)->nullable();
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
        Schema::dropIfExists('obrasocial');
    }
}
