<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreceita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treceitas', function (Blueprint $table) {
            $table->integer('controle')->autoIncrement();
            $table->string('prescricao', 100);
            $table->integer('codpaciente');
            $table->foreign('codpaciente')->references('controle')->on('tpaciente')->onDelete('restrict');
            $table->integer('codmedico');
            $table->foreign('codmedico')->references('controle')->on('tmedico')->onDelete('restrict');
            $table->integer('codmedicamento');
            $table->foreign('codmedicamento')->references('controle')->on('tmedicamento')->onDelete('restrict');
            $table->date('dataprescricao');
            $table->string('dosagem', 50);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treceitas');
    }
}
