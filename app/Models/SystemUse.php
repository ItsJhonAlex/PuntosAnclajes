<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemUse extends Model
{
    use HasFactory;
    protected $table = 'isi_uso_sistemas_proteccion';

    protected $fillable = [
        'uso_sistema_proteccion',
    ];
}
