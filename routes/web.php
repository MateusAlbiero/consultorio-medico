<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('home', 'LoginController@redirecionarLogin');

Route::prefix('login')->group(function () {
    Route::get('/', 'LoginController@redirecionarLogin');
    Route::get('entrar', 'LoginController@entrar')->name('login.entrar');
    Route::get('sair', 'LoginController@sair')->name('login.sair');
});

Route::prefix('paciente')->group(function () {
    Route::get('/', 'PacienteController@index')->name('paciente');
    Route::get('getpaciente', 'PacienteController@getPaciente')->name('paciente.get');
    Route::get('cadastro/{id}', 'PacienteController@cadastro')->name('paciente.cadastro');
    Route::get('buscar/{busca?}', 'PacienteController@buscar')->name('paciente.buscar');
    Route::post('gravar', 'PacienteController@gravar')->name('paciente.gravar');
});

Route::prefix('medico')->group(function () {
    Route::get('/', 'MedicoController@index')->name('medico');
    Route::get('getmedico', 'MedicoController@getMedico')->name('medico.get');
    Route::get('cadastro/{id}', 'MedicoController@cadastro')->name('medico.cadastro');
    Route::get('buscar/{busca?}', 'MedicoController@buscar')->name('medico.buscar');
    Route::post('gravar', 'MedicoController@gravar')->name('medico.gravar');
});