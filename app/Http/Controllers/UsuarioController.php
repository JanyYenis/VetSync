<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Pais;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {

    }

    public function perfil(Request $request)
    {
        $info['usuario'] = auth()->user();
        $info['generos'] = Usuario::darTipoGenero();
        $info['tipo_documentos'] = Usuario::darTipoDocumento();
        $info['paises'] = Pais::where('estado', Pais::ACTIVO)->orderBy('nombre')->get();

        return view('perfil', $info);
    }

    public function listado(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {
        $datos = $request->all();
        $usuario = Usuario::firstWhere('uuid', $datos['uuid']);

        $actualizar = $usuario->update($datos);

        if (!$actualizar) {
            throw new ErrorException('Error al intentar actualizar el usuario.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente el usuario.',
        ];
    }

    public function delete(Request $request)
    {

    }
}
