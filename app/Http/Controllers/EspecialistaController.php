<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\EspecialistaModel;

use Illuminate\Support\Facades\Redirect;

use DB;

use Flash;

use Illuminate\Support\Facades\Crypt;


class EspecialistaController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request){
		if ($request) {
			/*$query=trim($request->get('searchText'));*/
            
            $especialistas=DB::table('especialista')->orderBy('Primer_Apellido','desc')->paginate(5);
            if ($especialistas == null) {
                Flash::message("No hay especialistas para mostrar");
            }
			return view('Especialista.mostrarEspecialistas', ["especialistas"=>$especialistas]);
		}
    }

    public function eliminarEspecialista($cedulaEspecialista)
    {
        /*$placaDecrypted = Crypt::decrypt($placa);*/
        $especialista= EspecialistaModel::find($cedulaEspecialista);

        if($especialista == null) {
                Flash::error("Error, no se ha encontrado al especialista con la cédula: " + $cedulaEspecialista);
                return redirect('especialistas');
            } else {

		//$especialista->estado= estado_deshabilitado;
        //$especialista->update();

        Flash::error('Especialista eliminado satisfactoriamente.');

        return redirect('especialistas');    
    }
    }

    public function editarEspecialista($cedulaEspecialista){
        /*$placa = Crypt::decrypt($placaParam);*/
        $especialista = EspecialistaModel::find($cedulaEspecialista);

        if($especialista == null) {
            Flash::error("Error, no se ha encontrado al especialista con la cédula: " + $cedulaEspecialista);
            return redirect('especialistas');    
        } else {
            return view('Especialista.editarEspecialista',["especialistaEditar"=>$especialista]);
        }
}

public function actualizarEspecialista($cedula, Request $request){

    $especialista= EspecialistaModel::find($cedula);

        if($especialista == null) {
            Flash::error("Error, no se ha encontrado al especialista con la cédula: " + $cedulaEspecialista);
            return redirect('especialistas');    
        } else {

    $especialista->Nombre=$request->get('nombre');
    $especialista->Primer_Apellido=$request->get('primer_apellido');
    $especialista->Segundo_Apellido=$request->get('segundo_apellido');

    $especialista->update();

    Flash::success('Especialista actualizado satisfactoriamente.');

    return redirect('especialistas');    
}
}

}