<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Mail\Confirmacion;
use App\Mail\cuentaCreada;
use Mail;
use App\Telefono;
use Illuminate\Auth\Events\Registered;
use App\Paciente;
use App\Cuentas_activa;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new user (patient) as well as their
    | validation and creation.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'logoutUsuarioRecienRegistrado';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        /*Para los campos que no tienen mensaje, en resources/lang/en/validation
         se les hizo un mensaje custom*/
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telefono'  => 'required|digits_between:8,12',
            'cedula_paciente' => 'required|string|max:255|unique:pacientes'
        ]);
    }

    public function mail($email, $name)
    {
       Mail::to($email)->send(new SendMailable($name));
       Auth::logout();
    }

    /**
     * Create a new user and patient after a valid registration.
     * Send an email confirming the registration to the new user.
     * @param  Request $request data entered in the registration form
     * @return \App\User
     */

    public function register(Request $request) {
        
        //Esto revisa si la creación por defecto de usuarios está activada o desactivada.
        $active_flag = Cuentas_activa::orderBy('id')->first()->cuentas_activas;

        /*Esto valida casi todo con el método de arriba*/
        $this->validator($request->all())->validate();

    
        $user = User::create([
            'name' =>  $request->name,
            'lastName' =>  $request->lastName. ' ' .   $request->lastName2,
            'email' =>  $request->email,
            'password' => bcrypt($request->password),
            'tipo' => 4,//tipo 4 = Paciente
            'active_flag' => $active_flag,
        ]); //Create a new user in users table.

        $paciente = Paciente::create([
            'id_user' => $user->id,
            'cedula_paciente' => $request->cedula_paciente,
            'nombre' => $request->name,
            'primer_apellido_paciente' => $request->lastName,
            'segundo_apellido_paciente' => $request->lastName2,
            'correo' => $request->email,
            'active_flag' => $active_flag,
        ]); //Create a new patient in pacientes table.


                $telefono = $request->input("telefono");
                $telefonoModel = new Telefono();
				$telefonoModel->paciente_id = $paciente->id;
				$telefonoModel->active_flag = 1;
				$telefonoModel->telefono = $telefono;
                $telefonoModel->save();
                
        event(new Registered($user));
    
        $this->guard()->login($user);
        Mail::to($request->input("email"))->send(new cuentaCreada($request->input("name"), $request->input("email")));//Send an email confirming the registration to the new user.
        return redirect($this->redirectPath());
    }
}
