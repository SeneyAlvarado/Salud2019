<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Carbon\Carbon;

use App\Bloqueo_especialistum;
use Illuminate\Http\Request;
use \Session;
use DB;
class Bloqueo_especialistumController extends Controller
{
	/**
	 * Variable to model
	 *
	 * @var bloqueo_especialistum
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(Bloqueo_especialistum $model)
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
		//$bloqueo_especialistas = Bloqueo_especialistum::where('active_flag', 1)->orderBy('id', 'desc')->get();

		$bloqueo_especialistas = DB::table('bloqueo_especialistas')
			->join('especialistas', 'bloqueo_especialistas.id_especialista', '=', 'especialistas.id')
			->where('especialistas.active_flag', 1)
			->where('bloqueo_especialistas.active_flag', 1)
			->join('dia_bloqueo_especialistas', 'bloqueo_especialistas.id_dia_bloqueo_especialistas', '=', 'dia_bloqueo_especialistas.id')
			->where('dia_bloqueo_especialistas.active_flag', 1)
			->select('especialistas.*', 'dia_bloqueo_especialistas.dia', 
			'bloqueo_especialistas.*','bloqueo_especialistas.id as id' )
			->get();
			/*->join('especialistas', 'especialista_servicios.id_especialista', '=', 'especialistas.id')
			->where('especialistas.active_flag', 1)
			->select('especialista_servicios.id_servicio', 
			'especialista_servicios.id_recinto', 
			'especialista_servicios.id_especialista',
			'recintos.descripcion as Recinto' ,
			'servicios.nombre as Servicio',
			'especialistas.nombre as nombreEspecialista', 
			'especialistas.primer_apellido_especialista as apellido1', 
			'especialistas.segundo_apellido_especialista as apellido2')
			->orderBy('id_recinto', 'asc')->get();*/

			//return $bloqueo_especialistas;
		$tipo_usuario = Auth::user()->tipo;
		if($tipo_usuario == 1) {
		return view('bloqueo_especialistas.index', compact('bloqueo_especialistas'));
		}
		if($tipo_usuario == 2) {
			return view('bloqueo_especialistas_especialista.index', compact('bloqueo_especialistas'));
		}
		if($tipo_usuario == 3) {
			return view('bloqueo_especialistas_asistente.index', compact('bloqueo_especialistas'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('bloqueo_especialistas.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{
		$bloqueo_especialistum = new Bloqueo_especialistum();

		$bloqueo_especialistum->name = ucfirst($request->input("name"));
		$bloqueo_especialistum->slug = str_slug($request->input("name"), "-");
		$bloqueo_especialistum->description = ucfirst($request->input("description"));
		$bloqueo_especialistum->active_flag = 1;
		$bloqueo_especialistum->author_id = $request->user()->id;

		$this->validate($request, [
					 'name' => 'required|max:255|unique:bloqueo_especialistas',
					 'description' => 'required'
			 ]);

		$bloqueo_especialistum->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The Bloqueo_especialistum \"<a href='bloqueo_especialistas/$bloqueo_especialistum->slug'>" . $bloqueo_especialistum->name . "</a>\" was Created.");

		return redirect()->route('bloqueo_especialistas.index');
	}

	public function guardarBloqueoEsp(Request $request, $dropEspecialistas, $dropDiasBloqueo, $datepickedInicio,
	$datepickedFin, $horaInicio, $horaFin)
	{

		//return json_encode(["a"=>$dropEspecialistas . $dropDiasBloqueo . $datepickedInicio. 
		//$datepickedFin . $horaInicio . $horaFin]);
		$bloqueo_especialistum = new Bloqueo_especialistum();

		$bloqueo_especialistum->id_especialista = $dropEspecialistas;
		$bloqueo_especialistum->id_dia_bloqueo_especialistas = $dropDiasBloqueo;
		$bloqueo_especialistum->fecha_inicio_bloqueo_especialista = Carbon::parse($datepickedInicio)->format('Y-m-d');
		$bloqueo_especialistum->fecha_fin_bloqueo_especialista = Carbon::parse($datepickedFin)->format('Y-m-d');
		$bloqueo_especialistum->hora_inicio_bloqueo_especialista = $horaInicio;
		$bloqueo_especialistum->hora_fin_bloqueo_especialista = $horaFin;
		$bloqueo_especialistum->active_flag = 1;

		//return json_encode(["a"=>$bloqueo_especialistum]);

		$bloqueo_especialistum->save();

		return json_encode(["varInnecesaria"=>"ESTOESNECESARIOSINOELAJAXNOSIRVE:c"]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Bloqueo_especialistum $bloqueo_especialistum)
	{
		//$bloqueo_especialistum = $this->model->findOrFail($id);

		return view('bloqueo_especialistas.show', compact('bloqueo_especialistum'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Bloqueo_especialistum $bloqueo_especialistum)
	{
		//$bloqueo_especialistum = $this->model->findOrFail($id);

		return view('bloqueo_especialistas.edit', compact('bloqueo_especialistum'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, Bloqueo_especialistum $bloqueo_especialistum, User $user)
	{

		$bloqueo_especialistum->name = ucfirst($request->input("name"));
    $bloqueo_especialistum->slug = str_slug($request->input("name"), "-");
		$bloqueo_especialistum->description = ucfirst($request->input("description"));
		$bloqueo_especialistum->active_flag = 1;//change to reflect current status or changed status
		$bloqueo_especialistum->author_id = $request->user()->id;

		$this->validate($request, [
					 'name' => 'required|max:255|unique:bloqueo_especialistas,name,' . $bloqueo_especialistum->id,
					 'description' => 'required'
			 ]);

		$bloqueo_especialistum->save();

		Session::flash('message_type', 'blue');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The Bloqueo_especialistum \"<a href='bloqueo_especialistas/$bloqueo_especialistum->slug'>" . $bloqueo_especialistum->name . "</a>\" was Updated.");

		return redirect()->route('bloqueo_especialistas.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Bloqueo_especialistum $bloqueo_especialistum, $id)
	{
		$bloqueo_especialistum = Bloqueo_especialistum::where('id', $id)->first();
		$bloqueo_especialistum->active_flag = 0;
		//return $bloqueo_especialistum;
		$bloqueo_especialistum->save();

		return redirect()->action('Bloqueo_especialistumController@index');
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(Bloqueo_especialistum $bloqueo_especialistum)
	{
		$bloqueo_especialistum->active_flag = 1;
		$bloqueo_especialistum->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The Bloqueo_especialistum ' . $bloqueo_especialistum->name . ' was Re-Activated.');

		return redirect()->route('bloqueo_especialistas.index');
	}
}
