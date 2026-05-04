<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Medicamento;
use App\Models\Prescripcion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PrescripcionController extends Controller
{
    public function index(Request $request)
    {
        return view('prescripciones.index');
    }

    public function create(Request $request)
    {
        $info['presentaciones'] = Medicamento::darTipoPresentacion();
        $info['frecuencias'] = Medicamento::darTipoFrecuencia();
        $info['duracion'] = Medicamento::darTipoDuracion();

        return view('prescripciones.crear', $info);
    }

    public function listado(Request $request)
    {
        $historiales = Prescripcion::selectRaw("prescripciones.id, prescripciones.fecha,
            m.nombre as nombre_mascota, c.nombre as nombre_propietario,
            prescripciones.created_at, prescripciones.estado, prescripciones.indicaciones")
            ->join('historial_clinicos as h', 'h.id', '=', 'cod_historial')
            ->join('clientes as c', 'c.id', '=', 'h.cod_cliente')
            ->join('mascotas as m', 'm.id', '=', 'h.cod_mascota')
            ->with('infoEstado')
            ->whereHas('veterinario.empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->where('prescripciones.estado', '!=', Prescripcion::ELIMINADO);

        return DataTables::eloquent($historiales)
            // ->filter(function ($query) {
            //     if (request()->has('search')) {
            //         $search = strtolower(request('search')['value']);

            //         $query->where(function($q) use ($search) {

            //             $q->where('historial_clinicos.codigo', 'like', "%{$search}%")
            //             ->orWhere('m.nombre', 'like', "%{$search}%")
            //             ->orWhere('c.nombre', 'like', "%{$search}%")
            //             ->orWhere('historial_clinicos.created_at', 'like', "%{$search}%");

            //             // 👇 estado personalizado
            //             if (str_contains($search, 'activo')) {
            //                 $q->orWhere('historial_clinicos.estado', 1);
            //             } elseif (str_contains($search, 'inactivo')) {
            //                 $q->orWhere('historial_clinicos.estado', 2);
            //             }
            //         });
            //     }
            // })
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
        // dd($datos);
        $prescripcion = Prescripcion::create([
            'cod_historial' => $datos['cod_historial'],
            'cod_usuario' => auth()->user()->id,
            'indicaciones' => $datos['indicaciones'],
            'fecha' => $datos['fecha'],
            'validez' => $datos['validez'],
            'confirmacion' => 1,
            'firma' => $datos['firma'],
        ]);

        if (!$prescripcion) {
            throw new ErrorException("Error al intentar crear un prescripcion.");
        }

        $prescripcion->refresh();

        // Verifica el ID
        if (empty($prescripcion->id)) {
            throw new ErrorException("El prescripcion no tiene un ID asignado.");
        }

        $medicamentos = json_decode($datos['medications']);
        $nuevos_medicamentos = [];
        foreach ($medicamentos as $medicamento) {
            $nuevos_medicamentos[] = Medicamento::create([
                'cod_prescripcion' => $prescripcion->id,
                'nombre' => $medicamento->name,
                'presentacion' => $medicamento->presentation,
                'dosis' => $medicamento->dose,
                'frecuencia' => $medicamento->frequency,
                'duracion' => $medicamento->duration,
                'tiempo' => $medicamento->durationUnit,
                'comentario' => $medicamento?->instructions ?? null,
            ]);
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente el historial.',
            'prescripcion' => $prescripcion->load(
                'veterinario.empresa',
                'historial.mascota.infoTipo',
                'historial.mascota.infoGenero',
                'historial.propietario',
            ),
            'nuevos_medicamentos' => $nuevos_medicamentos,
        ];
    }

    public function edit(Request $request, Prescripcion $historial)
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

    public function update(Request $request, Prescripcion $historial)
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

    public function delete(Prescripcion $historial)
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

        $historiales = Prescripcion::selectRaw('id, nombre as text')
            ->where(function($query) use($filtro){
                $query->whereRaw("LOWER(nombre) LIKE LOWER(?)", $filtro);
            })
            ->where('estado', Prescripcion::ACTIVO)
            ->orderBy('text')
            ->get();

        return response()->json($historiales);
    }

    public function darPresentacion(Request $request)
    {
        return response()->json(Medicamento::darTipoPresentacion());
    }

    public function darFrecuencia(Request $request)
    {
        return response()->json(Medicamento::darTipoFrecuencia());
    }

    public function darDuracion(Request $request)
    {
        return response()->json(Medicamento::darTipoDuracion());
    }
}
