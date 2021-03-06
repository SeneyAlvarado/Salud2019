@extends ('masterRoot')
@section ('contenido_Admin')

<div class="panel panel-primary class border-panel ">
  <div class="panel-heading border-panel bg-color-panel">
    <p class="center" style="font-size: 3vh;">Configuración de horarios</p>
  </div>
  <div class="panel-body">
    <section class="">

      <div class="panel-heading">
        <div class="center">
          <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default class border-panel">

              <div class="panel-body center">
                <img class="img-responsive" src="{{asset('Imagenes/doc.jpg')}}" alt="Smiley face" max-width="100%"
                  height="200" border="1">
                <br>
                <div class="col-md 12" style="overflow: auto; width: auto;">
                  <a class="btn btn-primary btn-block" style="overflow: auto; width: auto;"
                    href="{{ route('bloqueo_especialistas.index') }}" style="margin-top: 7px"><strong>Bloqueo Horario
                      Especialistas</strong></a>
                  <a class="btn btn-primary btn-block" style="overflow: auto; width: auto;"
                    href="{{ route('deshab_especialistas.index') }}" style="margin-top: 7px"><strong>Deshabilitar
                      Horario Especialistas</strong></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 ">
            <div class="panel panel-default class border-panel">
              <div class="panel-body center">
                <img class="img-responsive" src="{{asset('Imagenes/servicios.jpg')}}" max-width="100%" height="220"
                  border="1">
                <a class="btn btn-primary btn-block" style="margin-top: 41px"
                  href="{{ route('horarios_servicios.index') }}"><strong>Horarios Servicios</strong></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@stop