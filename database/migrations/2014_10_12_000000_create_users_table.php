<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('surname');
            $table->string('role');
            $table->string('direccion', 100)->nullable();
            $table->string('provincia', 100)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('condicion_iva', 45)->nullable();
            $table->string('condicion_iibb', 45)->nullable();
            $table->string('cuit', 45)->nullable();
            $table->string('iibb', 45)->nullable();
            $table->string('entidad_bancaria', 75)->nullable();
            $table->string('cbu', 45)->nullable();
            $table->string('orden_cheque', 45)->nullable();
            $table->string('lugar_pago', 45)->nullable();
            $table->string('emp_seguros', 45)->nullable();
            $table->string('poliza', 45)->nullable();
            $table->tinyInt('active')->default('1');
            $table->tinyInt('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
