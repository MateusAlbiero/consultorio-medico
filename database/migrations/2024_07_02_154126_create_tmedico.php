<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmedicos', function (Blueprint $table) {
            $table->integer('controle')->autoIncrement();
            $table->string('nome', 100);
            $table->string('especialidade');
            $table->string('cpf', 11);
            $table->string('crm')->unique();
            $table->string('endereco', 100)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('numero', 5)->nullable();
            $table->string('complemento', 50)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('email', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmedicos');
    }
}
