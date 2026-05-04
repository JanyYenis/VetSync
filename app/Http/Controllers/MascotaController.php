<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MascotaController extends Controller
{
    public function index(Request $request)
    {
        $info['generos'] = Mascota::darTipoGenero();
        $info['tipos'] = Mascota::darTipo();

        return view('mascotas.index', $info);
    }

    public function listado(Request $request)
    {
        $mascotas = Mascota::selectRaw("id, nombre, raza, tipo, edad, peso, genero, color, estado, cod_cliente")
            ->with('infoEstado', 'infoTipo', 'propietario')
            ->whereHas('propietario.empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->where('estado', '!=', Mascota::ELIMINADO);

        return DataTables::eloquent($mascotas)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = strtolower(request('search')['value']);

                    $query->where(function($q) use ($search) {

                        $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('raza', 'like', "%{$search}%")
                        ->orWhere('edad', 'like', "%{$search}%")
                        ->orWhere('color', 'like', "%{$search}%")
                        ->orWhere('peso', 'like', "%{$search}%");

                        // 👇 estado personalizado
                        if (str_contains($search, 'activo')) {
                            $q->orWhere('estado', 1);
                        } elseif (str_contains($search, 'inactivo')) {
                            $q->orWhere('estado', 2);
                        }
                        // 👇 tipo personalizado
                        if (str_contains($search, 'perro')) {
                            $q->orWhere('tipo', 1);
                        } elseif (str_contains($search, 'gato')) {
                            $q->orWhere('tipo', 2);
                        } elseif (str_contains($search, 'ave')) {
                            $q->orWhere('tipo', 3);
                        } elseif (str_contains($search, 'conejo')) {
                            $q->orWhere('tipo', 4);
                        } elseif (str_contains($search, 'pez')) {
                            $q->orWhere('tipo', 5);
                        } elseif (str_contains($search, 'otro')) {
                            $q->orWhere('tipo', 6);
                        }
                    });
                }
            })
            ->addColumn('tipo', 'mascotas.columnas.tipo')
            ->addColumn('edad', function($model) {
                return $model?->edad ? $model?->edad.' año(s)' : 'N/A';
            })
            ->addColumn('nombre', 'mascotas.columnas.nombre')
            ->addColumn('propietario', function($model) {
                return $model?->propietario?->nombre ?? 'N/A';
            })
            ->addColumn('genero', function($model) {
                return $model?->infoGenero?->nombre ?? 'N/A';
            })
            ->addColumn('peso', function($model) {
                return $model?->peso ? $model?->peso.' Kg' : 'N/A';
            })
            ->addColumn("estado", function ($model) {
                $info['concepto'] = $model?->infoEstado;
                return view("sistema.estado", $info);
            })
            ->addColumn("action", "mascotas.columnas.acciones")
            ->rawColumns(["action", "estado", "tipo", "nombre"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $mascota = Mascota::create($datos);

        if (!$mascota) {
            throw new ErrorException("Error al intentar crear un mascota.");
        }

        $mascota->refresh();

        // Verifica el ID
        if (empty($mascota->id)) {
            throw new ErrorException("El mascota no tiene un ID asignado.");
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente el mascota.',
        ];
    }

    public function edit(Request $request, Mascota $mascota)
    {
        $mascota->load(
            'propietario'
        );

        $info['mascota'] = $mascota;
        $info['generos'] = Mascota::darTipoGenero();
        $info['tipos'] = Mascota::darTipo();

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("mascotas.modals.secciones.editar", $info)->render();

        return response()->json($respuesta);
    }

    public function update(Request $request, Mascota $mascota)
    {
        $datos = $request->all();
        $actualizar = $mascota->update($datos);

        if (!$actualizar) {
            throw new ErrorException('A ocurrido un error al intentar actualizar el mascota.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente el mascota.',
        ];
    }

    public function delete(Mascota $mascota)
    {
        $eliminar = $mascota->eliminar();

        if (!$eliminar) {
            throw new ErrorException('A ocurrido un error al intentar eliminar el mascota.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se eliminado correctamente el mascota.',
        ];
    }

    public function buscar(Request $request)
    {
        $nombre = $request->get("busqueda");
        $filtro = "%$nombre%";

        $mascotas = Mascota::selectRaw('mascotas.id, mascotas.nombre as text, co.nombre as tipo, c.nombre as dueno')
            ->join('clientes as c', 'c.id', '=', 'mascotas.cod_cliente')
            ->join('conceptos as co', 'co.codigo', '=', 'mascotas.tipo')
            ->join('tipos_conceptos as tc', 'tc.id', '=', 'co.id_tipo')
            ->where(function($query) use($filtro){
                $query->whereRaw("LOWER(mascotas.nombre) LIKE LOWER(?)", $filtro)
                    ->orWhereRaw("LOWER(co.nombre) LIKE LOWER(?)", $filtro)
                    ->orWhereRaw("LOWER(c.nombre) LIKE LOWER(?)", $filtro);
            })
            ->where('mascotas.estado', Mascota::ACTIVO)
            ->where('tc.nombre', Mascota::TC_TIPO)
            ->orderBy('text')
            ->get();

        return response()->json($mascotas);
    }
}
