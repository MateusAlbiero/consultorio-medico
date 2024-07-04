<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $connection = '';
    protected $table = 'tpaciente';
    protected $primaryKey = 'controle';
    public $timestamps = false;
}