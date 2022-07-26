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
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.censar', $estudiante->socioeconomico->id_estudiante) }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-0">
                                    <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('Registro del Estudiante') }} </b> </h1>
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
                                <div class="row mb-0">
                                    <label class="col-md-4 col-form-label text-md-right">Nombre:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }}</b>
                                    </label></div>
                                </div>
                                <div class="row mb-0">
                                    <label class="col-md-4 col-form-label text-md-right">Escuela:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->escuela->escuela }}</b>
                                    </label></div>
                                </div>
                                <div class="row mb-0">
                                    <label class="col-md-4 col-form-label text-md-right">Carrera:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->carrera }}</b>
                                    </label></div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label text-md-right">Ciudad Escuela:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->ciudad->ciudad }}</b>
                                    </label></div>
                                </div>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-danger">
                                            <b>INFORMACIÓN SOCIOECONÓMICA</b>
                                        </div>
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
                                             <div class="card-body">
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿De qué material es el techo de tu vivienda? <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->techo->techo }} &nbsp; </b> </label>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkTecho" checked>
                                                    </div>
                                                </div> 
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Cuántos cuartos y baños disponen en tu vivienda? (Incluye cocina, sala, etc.) <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->cuartos_vivienda }} &nbsp;</b> </label>
                                                        </p> 
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkCuartos" checked>
                                                    </div>                   
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Cuántas personas viven normalmente en tu vivienda? (Incluye a personas de todas las edades que vivan ahí.) <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->personas_vivienda }} &nbsp;</b> </label>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkPersonas" checked>
                                                    </div>                
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Cuál es el monto mensual que entra a tu hogar? (Incluye el sueldo de cualquier persona que viva en tu vivienda.) <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->monto_mensual->monto }} &nbsp;</b> </label> 
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkMonto" checked>
                                                    </div>  
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Recibes alguna beca para apoyar tus estudios? <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->beca_estudios == 1 ? 'SÍ' : 'NO'  }} &nbsp;</b> </label> 
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkBeca" checked>
                                                    </div>  
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Recibes algún tipo de ayuda económica del gobierno? <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->apoyo_gobierno == 1 ? 'SÍ' : 'NO'  }} &nbsp;</b> </label> 
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkBeca" checked>
                                                    </div>  
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Tienes algún empleo? <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ strlen(trim($estudiante->socioeconomico->empleo)) > 0 ? 'SÍ' : 'NO'  }} &nbsp;</b> </label> <br>
                                                            @if (strlen(trim($estudiante->socioeconomico->empleo)) > 0)
                                                                Especifica: <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ $estudiante->socioeconomico->empleo }} &nbsp;</b> </label> 
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkEmpleo" checked>
                                                    </div>  
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-11">
                                                        <p class="text-justify">
                                                            ¿Cuánto gastas en transporte diario a la escuela? (Taxi, camión, etc.) <label style="background:#dddddd; color:#ff4837"> <b> &nbsp; {{ '$ ' . number_format($estudiante->socioeconomico->gasto_transporte) . '.00' }} </b> &nbsp; </label>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-1 form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkTransporte" checked>
                                                    </div> 
                                                </div>
                                                <div class="row mb-0">
                                                    <div class="col-md-12 mb-0">
                                                        <p class="text-justify mb-0">
                                                            Observaciones: <textarea id="observaciones" rows=4 type="text" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" value="{{ old('observaciones', $estudiante->socioeconomico->observaciones) }}" required autocomplete="observaciones" autofocus></textarea>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>    
                                <div class="row mb-0">
                                    <div class="text-center col-md-12">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Censar') }}
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