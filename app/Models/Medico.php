<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $connection = '';
    protected $table = 'tmedico';
    protected $primaryKey = 'controle';
    public $timestamps = false;
}