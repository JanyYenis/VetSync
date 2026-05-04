<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Prescripcion;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargo correctamente la informacion',
            'cantidad_clientes' => $cantidad_clientes,
            'cantidad_mascotas' => $cantidad_mascotas,
            'cantidad_prescipciones' => $cantidad_prescipciones,
        ];
    }
}
