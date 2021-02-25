<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestador', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('os_id');
            $table->integer('prestacion_id');
            $table->string('numero_prestador', 45);  
            $table->string('valor_default', 1);     
            $table->decimal('valor_prestacion', 10, 2)->nullable();
            $table->string('mover_dias', 30);
            $table->string('quitar_feriado', 2);
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
        Schema::dropIfExists('prestador');
    }
}
