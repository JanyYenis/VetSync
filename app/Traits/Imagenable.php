<?php

namespace App\Traits;

use App\Models\Imagen;
use Illuminate\Support\Facades\Auth;

trait Imagenable
{
    /**
     * Función que permite obtener los imagenes relacionados a un registro.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany Relación polimórfica.
     */
    public function imagenes()
    {
        return $this->morphMany(Imagen::class, "imagenable");
    }

    /**
     * Función que permite obtener un imagen relacionado a un registro.
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne Relación polimórfica.
     */
    public function imagenesActivas()
    {
        return $this->imagenes()
            ->where('estado', Imagen::ACTIVO)
            ->orderBy('orden');
    }

    /**
     * Función que permite obtener un imagen relacionado a un registro.
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne Relación polimórfica.
     */
    public function imagen()
    {
        return $this->morphOne(Imagen::class, "imagenable");
    }

    /**
     * Función que permite obtener un imagen relacionado a un registro.
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne Relación polimórfica.
     */
    public function imagenActiva()
    {
        return $this->imagen()
            ->where('estado', Imagen::ACTIVO)
            ->orderBy('orden');
    }

    /**
     * Función que permite crear un imagen y relacionarlo inmediatamente con el modelo
     * seleccionado.
     * @param array $datos Datos a registrar sobre el imagen.
     */
    public function crearImagen($datos)
    {
        $imagen = new Imagen($datos);
        $imagen = $this->imagen()->save($imagen);
        if (!$imagen) {
            return [
                'estados' => 'error',
                'mensaje' => 'Ha ocurrido un error al intentar agregar el imagen'
            ];
        }
        return $imagen;
    }

    public function inactivarImagenes()
    {
        return $this->imagenes()
            ->where('estado', Imagen::ACTIVO)
            ->update([
                'estado' => Imagen::ELIMINADO,
            ]);
    }
}
