@extends('masterRoot')
@section('contenido_Admin')

<script src="{{asset('js/Servicio_Especialista.js')}}"></script>
<div class="panel panel-primary border-panel">
    <div class="panel-heading bg-color-panel">
        <p style="text-align: center; font-size: 3vh;">Vincular Especialista a Servicio</p>
    </div>
    <br />
    <div class="panel-body">
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{@session('message')}}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{@session('error')}}
        </div>
        @endif
        <div class="row" style="margin-top: 10px">
            <div style="margin-bottom: 15px;" class="col-md-3"><select id="dropRecintos" class="form-control"></select>
            </div>
            <div style="margin-bottom: 15px;" class="col-md-3"><select id="dropServicios" class="form-control"></select>
            </div>
            <div style="margin-bottom: 15px;" class="col-md-3"><select id="dropEspecialistas"
                    class="form-control"></select></div>
            <div class="col-md-3 fix_citas_diarias"><label
                    for="max_citas_diarias">Máximo de
                    citas diarias</label> <a href="#"><span class="glyphicon glyphicon-question-sign"
                        data-toggle="tooltip" data-original-title="Máximo de citas diarias para el servicio. 
                        Si es '0', la cantidad de citas para el servicio es indefinida"></span></a>
                <input id="max_citas_diarias" type="text" style="width: 170px;" class="form-control"
                    name="max_citas_diarias" value="{{ old('max_citas_diarias') }}" requiredautofocus maxlength="2"
                    onkeyup="max_citas_number();"></div>
        </div>

        <style>
            /* On screens that are 992px wide or less, adjust max citas field */
            @media screen and (max-width: 992px) {
                .fix_citas_diarias {
                    position: relative !important;
                    bottom: 0px !important;
                }
                .boton_vincular{
                    position: relative !important;
                    top: 10px !important;
                }
            }
            /* On screens that are 992px wide or more, adjust max citas field */
            @media screen and (min-width: 992px) {
                .fix_citas_diarias {
                    position: relative !important;
                    bottom: 25px !important;
                }
                .boton_vincular{
                    position: relative !important;
                    bottom: 0px !important;
                }
            }
        </style>
        <div class="row boton_vincular">
            <div class="col-md-offset-5 col-md-1">
                <a class="margin-button-agregar btn btn-success mobile" onclick="vincular()">Vincular</a>
            </div>
        </div>
    </div>


    <div>
        <div class="panel-heading">
            <div class="">
                <div class="">
                    @if($vinculos->count())
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Servicio</th>
                                    <th class="text-center">Recinto</th>
                                    <th class="text-center">Especialista</th>
                                    <th class="text-center">Máximo <br>citas diarias</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($vinculos as $especialista_servicio)
                                <tr>

                                    <td class="text-center">{{$especialista_servicio->Servicio}}</td>
                                    <td class="text-center">{{$especialista_servicio->Recinto}}</td>
                                    <td class="text-center">{{$especialista_servicio->nombreEspecialista}}
                                        {{$especialista_servicio->apellido1}} {{$especialista_servicio->apellido2}}</td>

                                    <td class="text-center">{{$especialista_servicio->max_citas_diarias}}

                                    <td class="text-center">

                                        <form
                                            action="{{ route('eliminarVinculoEspecialista1', ['servicio'=>$especialista_servicio->id_servicio, 
                                    'recinto'=>$especialista_servicio->id_recinto, 'especialista'=>$especialista_servicio->id_especialista]) }}"
                                            style="display: inline;" onsubmit="return confirm('¿Desea eliminarlo?');">

                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h3 class="text-center alert alert-info">No hay elementos para mostrar</h3>
                        @endif

                    </div>
                    <a class="btn btn-link pull-right" href="{{ route('servicio.index') }}"><i
                            class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>
    @endsection