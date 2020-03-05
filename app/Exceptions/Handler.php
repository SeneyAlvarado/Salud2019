<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
 /**
  * A list of the exception types that are not reported.
  *
  * @var array
  */
 protected $_dontReport = [
  //
 ];

 /**
  * A list of the inputs that are never flashed for validation exceptions.
  *
  * @var array
  */
 protected $_dontFlash = [
  'password',
  'password_confirmation',
 ];

 /**
  * Report or log an exception.
  *
  * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
  *
  * @param  \Exception  $exception
  * @return void
  */
 public function report(Exception $exception)
 {
  parent::report($exception);
 }

 /**
  * Render an exception into an HTTP response.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Exception  $exception
  * @return \Illuminate\Http\Response
  */
 public function render($request, Exception $e)
 {

    return parent::render($request, $e);
  $errorRoute = '/error';

  if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
    return response()->view('errors.404', [], 404);
    /*Session::flash('message', '¡La página a la que ha intentado acceder no existe o no es accesible en este momento!'); 
   flash('¡La página a la que ha intentado acceder no existe o no es accesible en este momento!');*/
   return redirect($errorRoute);

  } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
   flash('¡Ha ocurrido un error con la sesión!');
   return redirect($errorRoute);

  } elseif ($e instanceof \Swift_TransportException) {
    flash('¡Ha ocurrido un error con el envío de un corrreo electrónico!'  .
    ' Si este persiste contacte al Servicio de Salud');
    return redirect($errorRoute);
 

  } elseif ($e instanceof \UnexpectedValueException) {
   flash('¡Ha ocurrido un error con un valor no válido !' .
    ' Si este persiste contacte al Servicio de Salud');
   return redirect($errorRoute);

  } elseif ($e instanceof \Illuminate\Database\QueryException) {
   flash('¡Ha ocurrido un error en la consulta a la base de datos al' .
    ' Si este persiste contacte al Servicio de Salud');
   return redirect($errorRoute);

  } elseif ($e instanceof \RuntimeException) {
   flash('¡Ha ocurrido un error de ejecución al procesar su solicitud!' .
    ' Si este persiste contacte al Servicio de Salud');
   return redirect($errorRoute);

  } elseif ($e instanceof \ErrorException) {
   flash('¡Ha ocurrido un error!' .
    ' Si este persiste contacte al Servicio de Salud');
   return redirect($errorRoute);

  } elseif ($e instanceof \Throwable) {
   flash('¡Ha ocurrido un error inesperado!' .
    ' Si este persiste contacte al Servicio de Salud');
   return redirect($errorRoute);

  } elseif ($e instanceof \Exception) { //this should be the LAST one, gets any Exception
   flash('¡Ha ocurrido un error procesando su solicitud' .
    ' Si este persiste contacte al Servicio de Salud');
   return redirect($errorRoute);

  } else { /*Original error handling, the code would never get here*/
   return parent::render($request, $e);
  }
 }
}
