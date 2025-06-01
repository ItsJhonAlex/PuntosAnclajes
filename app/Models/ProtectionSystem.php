<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtectionSystem extends Model
{
    use HasFactory;
    protected $table = 'isi_tipo_sistemas_proteccion';

    protected $fillable = [
        'nombre'
    ];
}
