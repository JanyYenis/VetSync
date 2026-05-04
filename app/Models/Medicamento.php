<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class Medicamento extends Model
{
    protected $table = 'medicamentos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    const TC_PRESENTACION = 'TC_PRESENTACION';
    const TABLETAS   = 1;
    const CAPSULAS   = 2;
    const JARABE     = 3;
    const INYECTABLE = 4;
    const GOTAS      = 5;
    const CREMA      = 6;
    const SUSPENSION = 7;
    const POLVO      = 8;

    const TC_FRECUENCIA = 'TC_FRECUENCIA';
    const SEIS_HORAS        = 1;
    const OCHO_HORAS        = 2;
    const DOCE_HORAS        = 3;
    const VENTICUATRO_HORAS = 4;
    const DOS_VECES_DIA     = 5;
    const TRES_VECES_DIA    = 6;
    const DOSIS_UNICA       = 7;
    const SEGUN_NECESIDAD   = 8;

    const TC_DURACION = 'TC_DURACION';
    const DIA     = 1;
    const SEMANAS = 2;
    const MESES   = 3;

    protected $fillable = [
        'cod_prescripcion',
        'nombre',
        'presentacion',
        'dosis',
        'frecuencia',
        'duracion',
        'tiempo',
        'estado',
        'comentario',
    ];

    protected $dates = [
        "created_at" => "date:d/m/Y",
        "updated_at" => "date:d/m/Y",
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

    public function infoPresentacion()
    {
        return darInfoConcepto($this, self::TC_PRESENTACION, 'presentacion')->selectRaw('conceptos.*');
    }

    public function infoFrecuencia()
    {
        return darInfoConcepto($this, self::TC_FRECUENCIA, 'frecuencia')->selectRaw('conceptos.*');
    }

    public function infoDuracion()
    {
        return darInfoConcepto($this, self::TC_DURACION, 'duracion')->selectRaw('conceptos.*');
    }

    public static function darTipoPresentacion($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_PRESENTACION, $infoTipoConcepto);
    }

    public static function darTipoFrecuencia($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_FRECUENCIA, $infoTipoConcepto);
    }

    public static function darTipoDuracion($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_DURACION, $infoTipoConcepto);
    }
}
