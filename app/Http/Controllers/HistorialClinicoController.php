<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Consulta;
use App\Models\HistorialClinico;
use App\Models\Mascota;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HistorialClinicoController extends Controller
{
    public function index(Request $request)
    {
        $info['generos'] = Mascota::darTipoGenero();
        $info['tipos'] = Mascota::darTipo();

        return view('historiales.index', $info);
    }

    public function listado(Request $request)
    {
        $historiales = HistorialClinico::selectRaw("historial_clinicos.id, historial_clinicos.codigo,
            m.nombre as nombre_mascota, c.nombre as nombre_propietario,
            historial_clinicos.created_at, historial_clinicos.estado")
            ->join('clientes as c', 'c.id', '=', 'cod_cliente')
            ->join('mascotas as m', 'm.id', '=', 'cod_mascota')
            ->with('infoEstado', 'consultasActivas')
            ->where('historial_clinicos.estado', '!=', HistorialClinico::ELIMINADO);

        return DataTables::eloquent($historiales)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = strtolower(request('search')['value']);

                    $query->where(function($q) use ($search) {

                        $q->where('historial_clinicos.codigo', 'like', "%{$search}%")
                        ->orWhere('m.nombre', 'like', "%{$search}%")
                        ->orWhere('c.nombre', 'like', "%{$search}%")
                        ->orWhere('historial_clinicos.created_at', 'like', "%{$search}%");

                        // 👇 estado personalizado
                        if (str_contains($search, 'activo')) {
                            $q->orWhere('historial_clinicos.estado', 1);
                        } elseif (str_contains($search, 'inactivo')) {
                            $q->orWhere('historial_clinicos.estado', 2);
                        }
                    });
                }

            })
            ->addColumn('codigo', function ($model) {
                return $model?->codigo ?? 'N/A';
            })
            ->addColumn('nombre_mascota', function ($model) {
                return $model?->nombre_mascota ?? 'N/A';
            })
            ->addColumn('nombre_propietario', function ($model) {
                return $model?->nombre_propietario ?? 'N/A';
            })
            ->addColumn('created_at', function ($model) {
                return $model?->created_at ?? 'N/A';
            })
            ->addColumn('consultas', 'historiales.columnas.consultas')
            ->addColumn("estado", function ($model) {
                $info['concepto'] = $model?->infoEstado;
                return view("sistema.estado", $info);
            })
            ->addColumn("action", "historiales.columnas.acciones")
            ->rawColumns(["action", "estado", "consultas"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $historial = HistorialClinico::create([
            'cod_mascota' => $datos['cod_mascota'],
            'cod_cliente' => $datos['cod_cliente'],
            'cod_usuario' => auth()->user()->uuid,
            'edad' => $datos['edad_mascota'],
            'peso' => $datos['peso_mascota'],
            'rabia' => $datos['rabia'] ? Carbon::parse($datos['rabia']) : null,
            'parvovirus' => $datos['parvovirus'] ? Carbon::parse($datos['parvovirus']) : null,
            'moquillo' => $datos['moquillo'] ? Carbon::parse($datos['moquillo']) : null,
            'desparasitacion_interna' => $datos['desparasitacion_interna'] ? Carbon::parse($datos['desparasitacion_interna']) : null,
            'desparasitacion_externa' => $datos['desparasitacion_externa'] ? Carbon::parse($datos['desparasitacion_externa']) : null,
            'alergias' => $datos['alergias'],
            'enfermedades_cronicas' => $datos['enfermedades_cronicas'],
            'observacion_general' => $datos['observacion_general'],
            'firma' => $datos['firma'],
        ]);

        if (!$historial) {
            throw new ErrorException("Error al intentar crear un historial.");
        }

        $historial->refresh();

        // Verifica el ID
        if (empty($historial->id)) {
            throw new ErrorException("El historial no tiene un ID asignado.");
        }

        $consultas = json_decode($datos['historialClinico']);
        foreach ($consultas as $consulta) {
            Consulta::create([
                'cod_historial' => $historial->id,
                'fecha' => $consulta?->fecha ? Carbon::parse($consulta?->fecha) : null,
                'motivo' => $consulta?->motivo ?? null,
                'diagnostico' => $consulta?->diagnostico ?? null,
                'tratamiento' => $consulta?->tratamiento ?? null,
            ]);
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente el historial.',
        ];
    }

    public function edit(Request $request, HistorialClinico $historial)
    {
        $historial->load(
            'mascota.infoTipo',
            'propietario',
            'consultasActivas',
        );

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargaron los datos correctamente.',
            'historial' => $historial,
        ];
    }

    public function update(Request $request, HistorialClinico $historial)
    {
        $datos = $request->all();
        $actualizar = $historial->update([
            'cod_mascota' => $datos['cod_mascota'],
            'cod_cliente' => $datos['cod_cliente'],
            'edad' => $datos['edad_mascota'],
            'peso' => $datos['peso_mascota'],
            'rabia' => $datos['rabia'] ? Carbon::parse($datos['rabia']) : null,
            'parvovirus' => $datos['parvovirus'] ? Carbon::parse($datos['parvovirus']) : null,
            'moquillo' => $datos['moquillo'] ? Carbon::parse($datos['moquillo']) : null,
            'desparasitacion_interna' => $datos['desparasitacion_interna'] ? Carbon::parse($datos['desparasitacion_interna']) : null,
            'desparasitacion_externa' => $datos['desparasitacion_externa'] ? Carbon::parse($datos['desparasitacion_externa']) : null,
            'alergias' => $datos['alergias'],
            'enfermedades_cronicas' => $datos['enfermedades_cronicas'],
            'observacion_general' => $datos['observacion_general'],
        ]);

        if (!$actualizar) {
            throw new ErrorException('A ocurrido un error al intentar actualizar el historial.');
        }

        $consultas = json_decode($datos['historialClinico']);
        if (count($consultas)) {
            Consulta::where('cod_historial', $historial->id)
                ->where('estado', Consulta::ACTIVO)
                ->update(['estado' => Consulta::ELIMINADO]);
            foreach ($consultas as $consulta) {
                Consulta::updateOrCreate([
                    'cod_historial' => $historial->id,
                    'fecha' => $consulta?->fecha ? Carbon::parse($consulta?->fecha) : null,
                    'motivo' => $consulta?->motivo ?? null,
                ], [
                    'diagnostico' => $consulta?->diagnostico ?? null,
                    'tratamiento' => $consulta?->tratamiento ?? null,
                    'estado' => Consulta::ACTIVO
                ]);
            }
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente el historial.',
        ];
    }

    public function delete(HistorialClinico $historial)
    {
        $eliminar = $historial->eliminar();

        if (!$eliminar) {
            throw new ErrorException('A ocurrido un error al intentar eliminar el historial.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se eliminado correctamente el historial.',
        ];
    }

    public function buscar(Request $request)
    {
        $nombre = $request->get("busqueda");
        $filtro = "%$nombre%";

        $historiales = HistorialClinico::selectRaw('historial_clinicos.id, CONCAT(codigo, " | ", m.nombre, " - ", c.nombre) as text')
            ->join('mascotas as m', 'm.id', '=', 'cod_mascota')
            ->join('clientes as c', 'c.id', '=', 'historial_clinicos.cod_cliente')
            ->where(function($query) use($filtro){
                $query->whereRaw('LOWER(CONCAT(codigo, " | ", m.nombre, " - ", c.nombre)) LIKE LOWER(?)', $filtro);
            })
            ->where('historial_clinicos.estado', HistorialClinico::ACTIVO)
            ->orderByDesc('historial_clinicos.created_at')
            ->get();

        return response()->json($historiales);
    }

    public function cargarDatos(Request $request, Mascota $mascota)
    {
        $mascota->load(
            'propietario'
        );

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargaron los datos correctamente.',
            'mascota' => $mascota,
        ];
    }
}
