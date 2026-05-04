<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    protected $fillable = [
        'nombre',
        'tipo_identificacion',
        'identificacion',
        'telefono',
        'email',
        'direccion',
        'cod_empresa',
        'estado',
    ];

    protected $dates = [
        "created_at" => "date:d/m/Y ",
        "updated_at" => "date:d/m/Y ",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            "created_at" => "date:d/m/Y",
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'cod_empresa', 'id');
    }

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'cod_cliente', 'id');
    }

    public function mascota()
    {
        return $this->hasOne(Mascota::class, 'cod_cliente', 'id');
    }

    public function mascotasActivas()
    {
        return $this->mascotas()->where('estado', Mascota::ACTIVO);
    }

    public function mascotaActiva()
    {
        return $this->mascota()->where('estado', Mascota::ACTIVO);
    }
}
