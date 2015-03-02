<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>@yield('TituloWeb','Sincronizador de horas.')</title>
        {{HTML::bootstrap()}}
    </head>
    <body>
        <div class="container">
            <div class="well">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Resultado de la sincronización</h1><h4><i>({{$cantidad}} trabajos pendientes por sincronizar)</i></h4>
                    </div>
                </div>
                @foreach($errorgrave as $error)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Error!</strong> {{$error}}
                </div>
                @endforeach
                @if($hayError)
                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-danger">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Errores de actividades y tareas (Khronos ACT, Tarea)</div>
                            <ul class="list-group">
                                @foreach($erroractividadtarea as $error)
                                <li class="list-group-item">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-danger">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Errores de Backlog (Khronos O/T)</div>
                            <ul class="list-group">
                                @foreach($errorbacklog as $error)
                                <li class="list-group-item">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-danger">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Errores de khronos</div>
                            <ul class="list-group">
                                @foreach($errorkhronos as $error)
                                <li class="list-group-item">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-3">
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Información de trabajo (Carga de horas)</div>
                            <ul class="list-group">
                                @foreach($infotrabajo as $info)
                                <li class="list-group-item">{{$info}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Información de actividades y tareas (Khronos ACT, Tarea)</div>
                            <ul class="list-group">
                                @foreach($infoactividadtarea as $info)
                                <li class="list-group-item">{{$info}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Información de Backlog (Khronos O/T)</div>
                            <ul class="list-group">
                                @foreach($infobacklog as $info)
                                <li class="list-group-item">{{$info}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Información de khronos</div>
                            <ul class="list-group">
                                @foreach($infokhronos as $info)
                                <li class="list-group-item">{{$info}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{HTML::script('js/bootstrap.min.js')}}
    </body>
</html>