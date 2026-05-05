<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class Consulta extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    protected $fillable = [
        'cod_historial',
        'fecha',
        'motivo',
        'diagnostico',
        'tratamiento',
        'estado',
    ];

    protected $dates = [
        "created_at" => "date:d/m/Y",
        "updated_at" => "date:d/m/Y",
        "fecha" => "date:d/m/Y",
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
            "fecha" => "date:d/m/Y",
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function historial()
    {
        return $this->belongsTo(HistorialClinico::class, 'cod_historial', 'id');
    }
}
