<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recertification extends Model
{
    use HasFactory;
    protected $table = 'isi_puntos_anclaje_recertificacion';

    protected $fillable = [
        'fecha_recertificacion',
        'observaciones',
        'estado',
        'propuesta_principal',
        'sistema_proteccion',
        'serial',
        'precinto',
        'marca',
        'numero_usuarios',
        'uso',
        'ubicacion',
        'propuesta_recertificacion',
        'id_empresa'
    ];

    protected $casts = [
        'fecha_recertificacion' => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function sistemaProteccion(){
        return $this->hasOne(ProtectionSystem::class, 'id', 'sistema_proteccion');
    }
}
