<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $connection = '';
    protected $table = 'treceita';
    protected $primaryKey = 'controle';
    public $timestamps = false;
}