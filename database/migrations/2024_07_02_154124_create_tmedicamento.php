<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedicamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmedicamentos', function (Blueprint $table) {
            $table->integer('controle')->autoIncrement();
            $table->string('descricao', 100);
            $table->integer('classeterapeutica', 10);
            $table->integer('classificacao', 10);
            $table->string('tarja', 100);
            $table->string('registroms', 15);
            $table->integer('tipomedicamento', 10);
            $table->string('controlado', 3);
            $table->string('fabricante', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmedicamentos');
    }
}
