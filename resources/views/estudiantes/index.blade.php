@extends('layouts.main')

<?php
    $usertype = auth()->user()->usertype;
    $i = 1;
?>
@section('content')
    <!-- Page Heading -->
    <div class="container-fluid">
        <div class="card mx-auto">
            <?php  
                if (session()->has('msg_type'))  $msg_type = session()->get('msg_type');
                else $msg_type = "info";
            ?>
            <div>
                @if (session()->has('message'))
                <div class="alert alert-{{ $msg_type }} mb-0">                        
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>                        
                    {!! html_entity_decode(session()->get('message')) !!}
                </div>
                <br>
                @endif 
            </div>
            <div class="card-header mt-0">
                <div class="row">
                    <div class="col">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mt-2 mb-0 text-gray-800"><b>
                            Estudiantes</b></h1>
                        </div>
                        <form method="GET" action="{{ route('estudiantes.index') }}">
                            <div class="form-row align-items-center">
                                <div class="col-md-3">
                                    <input type="search" name="search" class="form-control mb-2" id="inlineFormInput" value="{{ old('search', $searchR) }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary mb-2"> Buscar </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>            
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th class="col-md-auto">#</th>
                        <th class="col-sm-4">Nombre</th>
                        <th class="col-sm-2">Escuela - Ciudad</th>
                        <th class="col-sm-3">Carrera</th>
                        <th class="col-md-auto"></th>
                      </tr>
                    </thead>
                     <tbody>
                        @foreach ($estudiantes as $estudiante)
                            <?php
                                if ($estudiante->cve_ciudad_escuela == 1) $ciudadEscuela = "MZT";
                                elseif ($estudiante->cve_ciudad_escuela == 2) $ciudadEscuela = "CLN";
                                else $ciudadEscuela = "NULL";

                                switch ($estudiante->cve_status)
                                {
                                    case 1:   //RECIBIDO
                                        $color = "#9944d9"; 
                                        break;
                                    case 2:  //REVISADO
                                        $color = "#0071bc";
                                        break; 
                                    case 3: //CENSADO
                                        $color = "#7dc3f5";
                                        break; 
                                    case 4: //RECHAZADO
                                        $color = "#ff0000";
                                        break;
                                    case 5: //PENDIENTE
                                        $color = "#ffe26e";
                                        break; 
                                    case 6: //ACEPTADO
                                        $color = "#00ff00";
                                        break;               
                                }
                            ?>
                            <tr title={{ $estudiante->status->descripcion }}>
                                <td scope="row" style="border-left: 4px solid {{ $color }}; vertical-align:middle">{{ $i++ }}</td>
                                <td style="vertical-align:middle">{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} &nbsp;</td>
                                <td style="vertical-align:middle">{{ $estudiante->escuela->escuela_abreviatura }} <i class="fas fa-map-marker-alt"></i> {{ $ciudadEscuela }} &nbsp;</td>
                                <td style="vertical-align:middle">{{ $estudiante->carrera }} &nbsp;</td>
                                <td style="vertical-align:middle"> <a href="{{ route('estudiantes.edit', $estudiante->id) }}" title="Editar" class="btn btn-success btn-sm"><i class="fas fa-user-edit"></i></a> <a href="{{ route('estudiantes.edit_status', $estudiante->id) }}" title="Cambiar estatus" class="btn btn-danger btn-sm"><i class="fas fa-flag"></i></a> @if ($estudiante->cve_status >= 2) <a href="{{ route('estudiantes.edit_se', $estudiante->id) }}" title="Censar" class="btn btn-primary btn-sm"><i class="fas fa-street-view"></i></a> @endif <a href="{{ route('estudiantes.registro_pdf_post', $estudiante->id_hex) }}" title="Imprimir" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a></td>
                            </tr> 
                            <?php 
                            ?>                         
                        @endforeach 
                    </tbody>
                </table>
            </div>
                  {{-- N° de registros: {{ $estudiantes->count() }} --}}
            </div>
        </div>
    </div>
@endsection