<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_perfil');
            $table->string('username');
            $table->string('password');
	        $table->string('correo');
            $table->string('telefono');
            $table->tinyInteger('estatus')->length(1);
            $table->longText('token');
	        $table->timestamp('token_expiracion')->nullable();
            $table->timestamps();

            $table->foreign('fk_perfil')
            ->references('id')
            ->on('perfiles')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
