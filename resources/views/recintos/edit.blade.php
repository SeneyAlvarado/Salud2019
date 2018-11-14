@extends ('masterRoot')
@section ('contenido_Admin')
<div class="panel panel-primary">
    <div class="panel-heading">
        <p style="text-align: center; font-size: 3vh;">Editar Recinto</p>
    </div>
    <div class="panel-body">
        <section class="">
        <div class="content-c w3-container">    
            <div class=" center">
  
               <div class="col-md-4 col-md-offset-4">
                
                    <form action="{{ route('recintos.update', $recinto->id) }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        

                        <div class="form-group">
                            <input class="form-control" type="text" name="descripcion" id="nombre-field" value="{{$recinto['descripcion']}}" />
                        </div> 
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a class="btn btn-link pull-right" href="{{ route('recintos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </section>
    </div>
</div>
@stop