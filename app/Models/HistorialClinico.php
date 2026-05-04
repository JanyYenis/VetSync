<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class HistorialClinico extends Model
{
    protected $table = 'historial_clinicos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    protected $fillable = [
        'codigo',
        'cod_mascota',
        'cod_cliente',
        'cod_usuario',
        'edad',
        'peso',
        'rabia',
        'parvovirus',
        'moquillo',
        'desparasitacion_interna',
        'desparasitacion_externa',
        'alergias',
        'enfermedades_cronicas',
        'observacion_general',
        'firma',
        'estado',
    ];

    protected $dates = [
        "created_at" => "date:d/m/Y",
        "updated_at" => "date:d/m/Y",
        "rabia" => "date:d/m/Y",
        "parvovirus" => "date:d/m/Y",
        "moquillo" => "date:d/m/Y",
        "desparasitacion_interna" => "date:d/m/Y",
        "desparasitacion_externa" => "date:d/m/Y",
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
            "rabia" => "date:d/m/Y",
            "parvovirus" => "date:d/m/Y",
            "moquillo" => "date:d/m/Y",
            "desparasitacion_interna" => "date:d/m/Y",
            "desparasitacion_externa" => "date:d/m/Y",
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });

        static::created(function ($model) {
            $model->refresh(); // 👈 CLAVE

            $model->updateQuietly([
                'codigo' => 'HC-' . str_pad($model->numero_consecutivo, 6, '0', STR_PAD_LEFT)
            ]);
        });
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'cod_historial', 'id');
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class, 'cod_historial', 'id');
    }

    public function consultasActivas()
    {
        return $this->consultas()->where('estado', Consulta::ACTIVO);
    }

    public function consultaActiva()
    {
        return $this->consulta()->where('estado', Consulta::ACTIVO);
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'cod_mascota', 'id');
    }

    public function propietario()
    {
        return $this->belongsTo(Cliente::class, 'cod_cliente', 'id');
    }
}
