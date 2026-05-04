<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $info['tipo_documentos'] = Usuario::darTipoDocumento();

        return view('clientes.index', $info);
    }

    public function listado(Request $request)
    {
        $clientes = Cliente::selectRaw("id, nombre, telefono, email, direccion, estado")
            ->with('infoEstado', 'mascotasActivas')
            ->whereHas('empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->where('estado', '!=', Cliente::ELIMINADO);

        return DataTables::eloquent($clientes)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = strtolower(request('search')['value']);

                    $query->where(function($q) use ($search) {

                        $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('telefono', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('direccion', 'like', "%{$search}%");

                        // 👇 estado personalizado
                        if (str_contains($search, 'activo')) {
                            $q->orWhere('estado', 1);
                        } elseif (str_contains($search, 'inactivo')) {
                            $q->orWhere('estado', 2);
                        }
                    });
                }

            })
            ->addColumn('telefono', function($model) {
                return $model?->telefono ? formatoTelefono($model->telefono) : 'N/A';
            })
            ->addColumn('nombre', 'clientes.columnas.nombre')
            ->addColumn('mascotas', 'clientes.columnas.mascotas')
            ->addColumn("estado", function ($model) {
                $info['concepto'] = $model?->infoEstado;
                return view("sistema.estado", $info);
            })
            ->addColumn("action", "clientes.columnas.acciones")
            ->rawColumns(["action", "estado", "mascotas", "nombre"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $datos['cod_empresa'] = auth()->user()->cod_empresa;
        $cliente = Cliente::create($datos);

        if (!$cliente) {
            throw new ErrorException("Error al intentar crear un cliente.");
        }

        $cliente->refresh();

        // Verifica el ID
        if (empty($cliente->id)) {
            throw new ErrorException("El cliente no tiene un ID asignado.");
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente el cliente.',
        ];
    }

    public function edit(Request $request, Cliente $cliente)
    {
        $info['cliente'] = $cliente;
        $info['tipo_documentos'] = Usuario::darTipoDocumento();

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("clientes.modals.secciones.editar", $info)->render();

        return response()->json($respuesta);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->all();
        $actualizar = $cliente->update($datos);

        if (!$actualizar) {
            throw new ErrorException('A ocurrido un error al intentar actualizar el cliente.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente el cliente.',
        ];
    }

    public function delete(Cliente $cliente)
    {
        $eliminar = $cliente->eliminar();

        if (!$eliminar) {
            throw new ErrorException('A ocurrido un error al intentar eliminar el cliente.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se eliminado correctamente el cliente.',
        ];
    }

    public function buscar(Request $request)
    {
        $nombre = $request->get("busqueda");
        $filtro = "%$nombre%";

        $clientes = Cliente::selectRaw('id, nombre as text')
            ->where(function($query) use($filtro){
                $query->whereRaw("LOWER(nombre) LIKE LOWER(?)", $filtro);
            })
            ->where('estado', Cliente::ACTIVO)
            ->orderBy('text')
            ->get();

        return response()->json($clientes);
    }
}
