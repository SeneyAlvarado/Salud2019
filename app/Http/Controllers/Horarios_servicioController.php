<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use DB;

use App\Horarios_servicio;
use Illuminate\Http\Request;
use \Session;

class Horarios_servicioController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var horarios_servicio
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(Horarios_servicio $model)
	{
		$this->model = $model;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$horarios_servicios = Horarios_servicio::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
		$active = Horarios_servicio::where('active_flag', 1);
		return view('horarios_servicios.index', compact('horarios_servicios', 'active'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('horarios_servicios.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{
		$horarios_servicio = new Horarios_servicio();
		
		//for ($i = 1; $i < 6; $i ++ ){
			$horarios_servicio->id_dia = $request->dia;
			$horarios_servicio->id_recinto = $request->recinto;
			$horarios_servicio->id_servicio = $request->servicio;
			$horarios_servicio->id_especialista = $request->especialista;
			$horarios_servicio->disponibilidad_manana = $request->manana;
			$horarios_servicio->disponibilidad_tarde = $request->tarde;
			$horarios_servicio->active_flag = 1;
			//$horarios_servicio->save();
		//}
		
		

		//$horarios_servicio->author_id = $request->user()->id;

		/*$this->validate($request, [
					 'name' => 'required|max:255|unique:horarios_servicios',
					 'description' => 'required'
			 ]);*/

			 $horarios_servicio->save();
		return redirect()->route('horarios_servicios.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Horarios_servicio $horarios_servicio)
	{
		//$horarios_servicio = $this->model->findOrFail($id);

		return view('horarios_servicios.show', compact('horarios_servicio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Horarios_servicio $horarios_servicio)
	{
		//$horarios_servicio = $this->model->findOrFail($id);

		return view('horarios_servicios.edit', compact('horarios_servicio'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, Horarios_servicio $horarios_servicio, User $user)
	{

		$horarios_servicio->name = ucfirst($request->input("name"));
    $horarios_servicio->slug = str_slug($request->input("name"), "-");
		$horarios_servicio->description = ucfirst($request->input("description"));
		$horarios_servicio->active_flag = 1;//change to reflect current status or changed status
		$horarios_servicio->author_id = $request->user()->id;

		$this->validate($request, [
					 'name' => 'required|max:255|unique:horarios_servicios,name,' . $horarios_servicio->id,
					 'description' => 'required'
			 ]);

		$horarios_servicio->save();
		return redirect()->route('horarios_servicios.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Horarios_servicio $horarios_servicio)
	{
		$horarios_servicio->active_flag = 0;
		$horarios_servicio->save();
		return redirect()->route('horarios_servicios.index');
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(Horarios_servicio $horarios_servicio)
	{
		$horarios_servicio->active_flag = 1;
		$horarios_servicio->save();
		return redirect()->route('horarios_servicios.index');
	}
	
/**
 * Receives an array as JSON about what the user chooses and then created or updates the schedule
 * of the recinto, especialista and servicio choosen. 
 *
 * @param Request $request
 * @param User $user
 * @param [JSON] $array_horario_servicio
 * @return void
 */
	public function annadirActualizarHorarios(Request $request, User $user, $array_horario_servicio)
	{
		
		$horarios_servicio_param = json_decode($array_horario_servicio);
		$hola = "Hola";
		for ($i = 0; $i < 5; $i ++ ){
			$horarios_servicio = new Horarios_servicio();
			$dia = $horarios_servicio_param[$i]->id_dia;
			$recinto = $horarios_servicio_param[$i]->id_recinto;
			$servicio = $horarios_servicio_param[$i]->id_servicio;
			$especialista = $horarios_servicio_param[$i]->id_especialista;
			$manana = $horarios_servicio_param[$i]->disponibilidad_manana;
			$tarde = $horarios_servicio_param[$i]->disponibilidad_tarde;

			$horarioServicios = Horarios_servicio::where('id_recinto', $recinto)->where('id_especialista', $especialista)
			->where('id_servicio', $servicio)->where('id_dia', $dia)->where('active_flag', 1)->get();
			//return $horarioServicios;

			if ($horarioServicios->isEmpty()) {
				$horarios_servicio->id_dia = $dia;
				$horarios_servicio->id_recinto = $recinto;
				$horarios_servicio->id_servicio = $servicio;
				$horarios_servicio->id_especialista = $especialista;
				$horarios_servicio->disponibilidad_manana = $manana;
				$horarios_servicio->disponibilidad_tarde = $tarde;
				$horarios_servicio->active_flag = 1;
				$horarios_servicio->save();

				Session::flash('message_type', 'negative');
				Session::flash('message_icon', 'hide');
				Session::flash('message_header', 'Success');
				Session::flash('message', 'Horario creado correctamente');//shows confirm message that the schedule was succesfully created
				
			} else {
				$id = $horarioServicios[0]->id;
				$actualizado = Horarios_servicio::find($id);
				$actualizado->disponibilidad_manana = $manana;
				$actualizado->disponibilidad_tarde = $tarde;
				$actualizado->save();

				Session::flash('message_type', 'negative');
				Session::flash('message_icon', 'hide');
				Session::flash('message_header', 'Success');
				Session::flash('message', 'Horario actualizado correctamente');//shows confirm message that the schedule was succesfully updated

			}
			
		}

			$tipo = Auth::user()->tipo;
                if($tipo == 3){
                return redirect()->route('Asistente.horarios');
                } else{
                    if($tipo == 2){
                return redirect()->route('Especialista.menuConfigHorarios');
                    } else{
                        if($tipo == 1){
							return redirect()->route('horarios_servicios.index');
                    }
                }
                }
               // return $dato;


		
	}

	/**
	 * Receives an array as JSON about what the user chooses and then created or updates the schedule
 	 * of the recinto, LOGGED especialista and servicio choosen. 
	 * @param Request $request
	 * @param User $user
	 * @param [type] $array_horario_servicio
	 * @return void
	 */
	public function annadirActualizarHorariosEspecialista(Request $request, User $user, $array_horario_servicio)
	{
		$name = Auth::user()->id;
		
    	$especialista = DB::table('especialistas')->where('id_user', $name)
        ->select('id')->get();
		$idS = $especialista->first()->id;
		
		$horarios_servicio_param = json_decode($array_horario_servicio);
		for ($i = 0; $i < 5; $i ++ ){
			$horarios_servicio = new Horarios_servicio();
			$dia = $horarios_servicio_param[$i]->id_dia;
			$recinto = $horarios_servicio_param[$i]->id_recinto;
			$servicio = $horarios_servicio_param[$i]->id_servicio;
			$especialista = $idS;
			$manana = $horarios_servicio_param[$i]->disponibilidad_manana;
			$tarde = $horarios_servicio_param[$i]->disponibilidad_tarde;

			$horarioServicios = Horarios_servicio::where('id_recinto', $recinto)->where('id_especialista', $especialista)
			->where('id_servicio', $servicio)->where('id_dia', $dia)->where('active_flag', 1)->get();
			//return $horarioServicios;

			if ($horarioServicios->isEmpty()) {
				$horarios_servicio->id_dia = $dia;
				$horarios_servicio->id_recinto = $recinto;
				$horarios_servicio->id_servicio = $servicio;
				$horarios_servicio->id_especialista = $especialista;
				$horarios_servicio->disponibilidad_manana = $manana;
				$horarios_servicio->disponibilidad_tarde = $tarde;
				$horarios_servicio->active_flag = 1;
				$horarios_servicio->save();

				Session::flash('message_type', 'negative');
				Session::flash('message_icon', 'hide');
				Session::flash('message_header', 'Success');
				Session::flash('message', 'Horario creado exitosamente');//shows message that confirms to user the schedule was created succesfully

			} else {
				$id = $horarioServicios[0]->id;
				$actualizado = Horarios_servicio::find($id);
				$actualizado->disponibilidad_manana = $manana;
				$actualizado->disponibilidad_tarde = $tarde;
				$actualizado->save();

				Session::flash('message_type', 'negative');
				Session::flash('message_icon', 'hide');
				Session::flash('message_header', 'Success');
				Session::flash('message', 'Horario actualizado exitosamente');//shows message that confirms to user the schedule was updated succesfully

			}
			
		}
		
		return redirect()->route('Especilista.horarios');
	}
}
