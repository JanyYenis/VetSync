<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\Prescripcion;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        DB::statement("SET lc_time_names = 'es_ES'");
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(Request $request)
    {
        $cantidad_clientes = Cliente::where('estado', Cliente::ACTIVO)
            ->whereHas('empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->count() ?? 0;
        $cantidad_mascotas = Mascota::where('estado', Mascota::ACTIVO)
            ->whereHas('propietario.empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->count() ?? 0;
        $cantidad_prescipciones = Prescripcion::where('estado', Prescripcion::ACTIVO)
            ->whereHas('veterinario.empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->count() ?? 0;

        $clientes_por_mes = Cliente::selectRaw("
            DATE_FORMAT(created_at, '%Y-%m') as mes,
            DATE_FORMAT(created_at, '%M %Y') as mes_nombre,
            COUNT(*) as cantidad
        ")
        ->groupBy('mes', 'mes_nombre')
        ->orderBy('mes')
        ->get();

        $label_clientes_por_mes = $clientes_por_mes->pluck('mes_nombre');
        $serie_clientes_por_mes   = $clientes_por_mes->pluck('cantidad');

        $tipos_mascotas = Mascota::selectRaw('c.nombre, COUNT(mascotas.id) as cantidad')
            ->join('conceptos as c', 'c.codigo', '=', 'mascotas.tipo')
            ->join('tipos_conceptos as tc', 'tc.id', '=', 'c.id_tipo')
            ->where('tc.nombre', Mascota::TC_TIPO)
            ->whereHas('propietario.empresa', function ($query) {
                $query->where('id', auth()->user()->cod_empresa);
            })
            ->groupBy('c.nombre')
            ->get()
            ->toArray();
        $label_tipo_mascotas = array_column($tipos_mascotas, 'nombre');
        $serie_tipo_mascotas = array_column($tipos_mascotas, 'cantidad');

        $ultimas_consultas = Consulta::with('historial.mascota.infoTipo', 'historial.propietario')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargo correctamente la informacion',
            'cantidad_clientes' => $cantidad_clientes,
            'cantidad_mascotas' => $cantidad_mascotas,
            'cantidad_prescipciones' => $cantidad_prescipciones,
            'label_tipo_mascotas' => $label_tipo_mascotas,
            'serie_tipo_mascotas' => $serie_tipo_mascotas,
            'label_clientes_por_mes' => $label_clientes_por_mes,
            'serie_clientes_por_mes' => $serie_clientes_por_mes,
            'ultimas_consultas' => $ultimas_consultas,
        ];
    }
}
