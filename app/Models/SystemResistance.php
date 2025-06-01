<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemResistance extends Model
{
    use HasFactory;
    protected $table = 'isi_resistencia_sistemas_proteccion';

    protected $fillable = [
        'cantidad_resistencia',
        'unidad_resistencia'
    ];
}
