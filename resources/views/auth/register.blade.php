
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary border-pane">
                <div class="panel-heading bg-color-panel" style="text-align: center; font-size: 18px">Registrarse</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Nombre" class="form-control" name="name" value="{{ old('name') }}" required autofocus pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,30}" title="Favor ingresar un formato correcto, solo se permiten letras">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                            <label for="lastName" class="col-md-4 control-label">Primer Apellido</label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" placeholder="Primer apellido" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,30}" title="Favor ingresar un formato correcto, solo se permiten letras">

                                @if ($errors->has('lastName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastName2') ? ' has-error' : '' }}">
                            <label for="lastName2" class="col-md-4 control-label">Segundo Apellido</label>

                            <div class="col-md-6">
                                <input id="lastName2" type="text" placeholder="Segundo apellido" class="form-control" name="lastName2" value="{{ old('lastName2') }}" required autofocus pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,30}" title="Favor ingresar un formato correcto, solo se permiten letras">

                                @if ($errors->has('lastName2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cedula_paciente') ? ' has-error' : '' }}">
                            <label for="cedula_paciente" class="col-md-4 control-label">Cédula</label>

                            <div class="col-md-6">
                                <input placeholder="Cédula con ceros y sin espacios, ej: 201230456" id="cedula_paciente" type="text" class="form-control" name="cedula_paciente" value="{{ old('cedula_paciente') }}" required autofocus>

                                @if ($errors->has('cedula_paciente'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cedula_paciente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Correo electrónico" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>El correo ya se encuentra registrado</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                <label for="telefono" class="col-md-4 control-label">Teléfono</label>
                            <div class="col-md-6">
                                <input id="telefono" placeholder="Teléfono" type="text" class="form-control" name="telefono"  size="8" maxlength="12" pattern="^[0-9]{8,12}" value="{{ old('telefono') }}" required title="No se permiten letras en este campo/Debe contener entre 8 y 12 dígitos.">
                                @if ($errors->has('telefono'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input minlength="6" id="password" type="password" placeholder="Contraseña" class="form-control" name="password" required minlength="6">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input minlength="6" id="password_confirmation" type="password" placeholder="Confirmar contraseña" class="form-control" name="password_confirmation" required minlength="6">
                            </div>
                        </div>

                        <div class="form-group"style="text-align:center">
                            <div class="">
                                <button type="submit" style="width:150px;" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@endsection
