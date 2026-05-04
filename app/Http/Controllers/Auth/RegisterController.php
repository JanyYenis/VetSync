<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'integer'],
            'tipo_identificacion' => ['required', 'integer'],
            'identificacion' => ['required', 'string'],
            'telefono' => ['required', 'integer'],
            'cod_ciudad' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return Usuario
     */
    protected function create(array $data)
    {
        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'genero' => $data['genero'],
            'tipo_identificacion' => $data['tipo_identificacion'],
            'identificacion' => $data['identificacion'],
            'cod_ciudad' => $data['cod_ciudad'],
            'telefono' => $data['telefono'],
            'codigo_telefono' => 57,
            'password' => Hash::make($data['password']),
        ]);

        if (!$usuario) {
            throw new ErrorException("Error al intentar crear un usuario.");
        }

        $usuario->refresh();

        // Verifica el ID
        if (empty($usuario->id)) {
            throw new ErrorException("El usuario no tiene un ID asignado.");
        }

        $path = null;
        if (isset($data['foto'])) {
            $path = $data['foto']->store('clinicas', 'public');
        }

        $clinica = Empresa::create([
            'razon_social' => $data['razon_social'],
            'nit' => $data['nit'],
            'direccion' => $data['direccion'],
            'email' => $data['email_clinica'],
            'telefono' => $data['telefono_clinica'],
            'instagram' => $data['instagram'],
            'facebook' => $data['facebook'],
            'tiktok' => $data['tiktok'],
            'cod_usuario' => $usuario->id,
            'foto' => $path,
        ]);

        if (!$clinica) {
            throw new ErrorException("Error al intentar crear un clinica.");
        }

        $clinica->refresh();

        // Verifica el ID
        if (empty($clinica->id)) {
            throw new ErrorException("El clinica no tiene un ID asignado.");
        }

        $usuario->update(['cod_empresa' => $clinica->id]);

        return $usuario;
    }
}
