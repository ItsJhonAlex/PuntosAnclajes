<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'isi_empresas';

    protected $fillable = [
        'nombre',
        'sede',
        'ciudad',
        'nit',
        'nombre_contacto_empresa',
        'telefono_contacto_empresa',
        'email_contacto_empresa',
        'nombre_contacto_empresa_2',
        'telefono_contacto_empresa_2',
        'email_contacto_empresa_2',
    ];

    public function puntoAnclaje()
    {
        return $this->hasMany(PuntoAnclaje::class,'id_empresa','id');
    }
}

