@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row justify-content-end mb-2">
                        <a href="{{ route('estudiantes.index') }}" class="float-right"><b><i class="fas fa-angles-left"></i>&nbsp; Atrás &nbsp;&nbsp;&nbsp;&nbsp;</b></a>
                    </div> 
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.update_status', $estudiante->id) }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-0">
                                    <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('Cambiar Estatus del Estudiante') }} </b> </h1>
                                </div>
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
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-body">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button> 
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                             </div>
                                             @endif
                                            <div class="row mb-0">
                                                <label class="col-md-4 col-form-label             text-md-right">Nombre:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }}</b>
                                                </label></div>
                                            </div>
                                            <div class="row mb-0">
                                                <label class="col-md-4 col-form-label             text-md-right">Escuela:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->escuela->escuela }}</b>
                                                </label></div>
                                            </div>
                                            <div class="row mb-1">
                                                <label class="col-md-4 col-form-label             text-md-right">Ciudad Escuela:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->ciudad->ciudad }}</b>
                                                </label></div>
                                            </div>
                                            <div class="row mb-0">
                                                <label class="col-md-4 col-form-label text-md-right">{{ __('Estatus') }} </label>
                                                <div class="col-md-5">
                                                    <select id="cve_status" name="cve_status" class="form-control">
                                                        @foreach ($status as $stat)
                                                            <option value="{{ $stat->cve_status }}" {{ $stat->cve_status == $estudiante->cve_status? 'selected' : '' }}>{{ $stat->cve_status . ' - ' . $stat->descripcion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection