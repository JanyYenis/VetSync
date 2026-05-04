<?php

namespace App\Models;

// use App\Notifications\CustomVerifyEmail;
// use App\Notifications\RecuperarContrasena;
// use App\Traits\Actividable;

use App\Classes\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
// use Spatie\Permission\Traits\HasRoles;

class Usuario extends User
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    const TC_GENERO_USUARIOS = 'TC_GENERO_USUARIOS';
    const MASCULINO = 1;
    const FEMENINO  = 2;

    const TC_TIPO_DOCUMENTO = 'TC_TIPO_DOCUMENTO';
    const CC = 1;
    const TI = 2;
    const PP = 3;

    protected $table = 'usuarios';
    protected $appends = ['nombre_completo', 'numero_completo'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'nombre',
        'apellido',
        'genero',
        'tipo_identificacion',
        'identificacion',
        'licencia',
        'email',
        'password',
        'telefono',
        'codigo_telefono',
        'cod_ciudad',
        'foto',
        'estado',
        'google2fa_secret',
        'cod_empresa',
        'external_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'ciudad.pais',
        'empresa',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // 'identificacion' => 'encrypted',
    ];

    protected $dates = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     */
    protected function google2faSecret(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) {
                    return null;
                }

                try {
                    return Crypt::decrypt($value);
                } catch (\Exception $e) {
                    // Si no puede desencriptar, devuelve el valor original para evitar errores
                    return $value;
                }
            },

            set: function ($value) {
                if (!$value) {
                    return null;
                }

                // Si llega encriptado, no lo vuelvas a encriptar
                if ($this->isEncrypted($value)) {
                    return $value;
                }

                return Crypt::encrypt($value);
            }
        );
    }

    private function isEncrypted($value)
    {
        try {
            Crypt::decrypt($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'cod_ciudad', 'id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'cod_empresa', 'id');
    }

    // public function autenticaciones()
    // {
    //     return $this->hasMany(Autenticacion::class, 'cod_usuario', 'id');
    // }

    // public function autenticacion()
    // {
    //     return $this->hasOne(Autenticacion::class, 'cod_usuario', 'id');
    // }

    public function infoGenero()
    {
        return darInfoConcepto($this, self::TC_GENERO_USUARIOS, 'genero')->selectRaw('conceptos.*');
    }

    public function infoDocumento()
    {
        return darInfoConcepto($this, self::TC_TIPO_DOCUMENTO, 'tipo_identificacion')->selectRaw('conceptos.*');
    }

    public static function darTipoGenero($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_GENERO_USUARIOS, $infoTipoConcepto);
    }

    public static function darTipoDocumento($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_TIPO_DOCUMENTO, $infoTipoConcepto);
    }

    public function getNombreCompletoAttribute()
    {
        $nombre = $this?->nombre ?? 'N/A';
        $apellido = '';
        if ($this->apellido) {
            $apellido = $this->apellido;
        }

        return $nombre.' '.$apellido;
    }

    public function getNumeroCompletoAttribute()
    {
        $tel = $this->codigo_telefono.$this->telefono;

        return $tel;
    }

    // /**
    //  * Send the password reset notification.
    //  *
    //  * @param  string  $token
    //  * @return void
    //  */
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new RecuperarContrasena($token));
    // }

    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new CustomVerifyEmail);
    // }
}
