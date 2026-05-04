<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    const TC_TIPO = 'TC_TIPO_MASCOTA';
    const PERRO   = 1;
    const GATO    = 2;
    const AVE     = 3;
    const CONEJO  = 4;
    const PEZ     = 5;
    const OTRO    = 6;

    const TC_GENERO_USUARIOS = 'TC_GENERO_USUARIOS';
    const MASCULINO = 1;
    const FEMENINO  = 2;

    protected $fillable = [
        'nombre',
        'tipo',
        'raza',
        'edad',
        'peso',
        'genero',
        'color',
        'cod_cliente',
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

    public function propietario()
    {
        return $this->belongsTo(Cliente::class, 'cod_cliente', 'id');
    }

    public function infoGenero()
    {
        return darInfoConcepto($this, self::TC_GENERO_USUARIOS, 'genero')->selectRaw('conceptos.*');
    }

    public static function darTipoGenero($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_GENERO_USUARIOS, $infoTipoConcepto);
    }

    public function infoTipo()
    {
        return darInfoConcepto($this, self::TC_TIPO, 'tipo')->selectRaw('conceptos.*');
    }

    public static function darTipo($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_TIPO, $infoTipoConcepto);
    }
}
