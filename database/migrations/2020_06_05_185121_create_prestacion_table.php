<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestacion', function (Blueprint $table) {
            $table->id();
            $table->integer('os_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('codigo_modulo')->nullable();
            $table->string('valor_modulo')->nullable();
            $table->tinyInteger('planilla')->nullable();
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
        Schema::dropIfExists('prestacion');
    }
}
