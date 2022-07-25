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
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.update', $estudiante->id) }}" enctype="multipart/form-data" novalidate>
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
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>I. INFORMACIÓN PERSONAL</b>
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
                                             <div class="row mb-3">
                                                <label for="curp" class="col-md-5 col-form-label text-md-right">{{ __('CURP') }}</label>
                                                <div class="col-md-6">
                                                    <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp', $estudiante->curp) }}"  autocomplete="curp" maxlength="18" required>
                                                    @error('curp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="nombre" class="col-md-5 col-form-label text-md-right">{{ __('Nombre') }}</label>
                                                <div class="col-md-6">
                                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $estudiante->nombre) }}" autocomplete="nombre" required>
                                                    @error('nombre')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="primer_apellido" class="col-md-5 col-form-label text-md-right">{{ __('Primer Apellido') }}</label>
                                                <div class="col-md-6">
                                                    <input id="primer_apellido" type="text" class="form-control @error('primer_apellido') is-invalid @enderror" name="primer_apellido" value="{{ old('primer_apellido', $estudiante->primer_apellido) }}"  autocomplete="primer_apellido" required>
                                                    @error('primer_apellido')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>  
                                            <div class="row mb-3">
                                                <label for="segundo_apellido" class="col-md-5 col-form-label text-md-right">{{ __('Segundo Apellido') }}</label>
                                                <div class="col-md-6">
                                                    <input id="segundo_apellido" type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" name="segundo_apellido" value="{{ old('segundo_apellido', $estudiante->segundo_apellido) }}"  autocomplete="segundo_apellido" required>
                                                    @error('segundo_apellido')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="fecha_nac" class="col-md-5 col-form-label text-md-right">{{ __('Fecha de Nacimiento') }}</label> 
                                                <div class="col-md-4">
                                                    <input id="fecha_nac" type="date" class="form-control @error('fecha_nac') is-invalid @enderror" name="fecha_nac" value="{{ old('fecha_nac', $estudiante->fecha_nac) }}" autocomplete="fecha_nac" required>
                                                    @error('fecha_nac')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="celular" class="col-md-5 col-form-label text-md-right">{{ __('N° Celular') }}</label>
                                                <div class="col-md-6">
                                                    <input id="celular" type="tel" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular', $estudiante->celular) }}"  autocomplete="celular" maxlength="10" required>
                                                    @error('celular')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="email" class="col-md-5 col-form-label text-md-right">{{ __('E-mail') }} </label>
                                                <div class="col-md-6">
                                                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $estudiante->email) }}" autocomplete="email" maxlength="40" required>                    
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="cve_localidad_origen" class="col-md-5 col-form-label text-md-right">{{ __('Lugar de Origen') }} </label>
                                                <div class="col-md-6">
                                                    <select id="cve_localidad_origen" name="cve_localidad_origen" class="form-control" aria-label="Default select example">
                                                        @foreach ($localidades as $localidad)
                                                            <option value="{{ $localidad->cve_localidad }}" {{ $localidad->cve_localidad == $estudiante->cve_localidad_origen? 'selected' : '' }}>{{ $localidad->localidad }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="cve_localidad_actual" class="col-md-5 col-form-label text-md-right">{{ __('Lugar de Transporte') }} </label>
                                                <div class="col-md-6">
                                                    <select id="cve_localidad_actual" name="cve_localidad_actual" class="form-control" aria-label="Default select example">
                                                        @foreach ($localidades as $localidad)
                                                            <option value="{{ $localidad->cve_localidad }}" {{ $localidad->cve_localidad == $estudiante->cve_localidad_actual? 'selected' : '' }}>{{ $localidad->localidad }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>   
                                        </div> 
                                    </div>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>II. INFORMACIÓN ESCOLAR</b>
                                        </div>
                                        <br>
                                        <div class="row mb-3">
                                            <label for="cve_escuela" class="col-md-5 col-form-label text-md-right">{{ __('Institución Educativa') }}</label>
                                            <div class="col-md-6">
                                                <select id="cve_escuela" name="cve_escuela" class="form-control" required>
                                                    <option value="" selected> -- SELECCIONA LA INSTITUCIÓN -- </option>
                                                    @foreach ($escuelas as $escuela)
                                                        <option value={{ $escuela->cve_escuela }} {{ $escuela->cve_escuela == $estudiante->cve_escuela ? 'selected' : '' }}>{{ $escuela->escuela_abreviatura }}</option>
                                                    @endforeach
                                                    <option disabled>____________________________________________________</option>
                                                    <option value="999" {{ "999" == $estudiante->cve_escuela ? 'selected' : '' }}> OTRA </option>
                                                </select>
                                                @error('cve_escuela')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="carrera" class="col-md-5 col-form-label text-md-right">{{ __('Carrera') }}</label>
                                            <div class="col-md-6">
                                                <input id="carrera" name="carrera" type="text" class="form-control @error('carrera') is-invalid @enderror" name="carrera" value="{{ old('carrera', $estudiante->carrera) }}" autocomplete="carrera" max="30" required>
                                                @error('nombre')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="cve_ciudad_escuela" class="col-md-5 col-form-label text-md-right">{{ __('Ciudad Escuela')}}</label>
                                            <div class="col-md-6">
                                                <select id="cve_ciudad_escuela" name="cve_ciudad_escuela"  class="form-control" required >
                                                    <option value="" selected> -- SELECCIONA LA CIUDAD -- </option>
                                                    @foreach ($ciudades as $ciudad)
                                                        <option value={{ $ciudad->cve_ciudad }} {{ $ciudad->cve_ciudad == $estudiante->cve_ciudad_escuela ? 'selected' : '' }}>{{ $ciudad->ciudad }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cve_ciudad_escuela')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="cve_turno_escuela" class="col-md-5 col-form-label text-md-right">{{ __('Turno Escuela')}}</label>
                                            <div class="col-md-6">
                                                <select id="cve_turno_escuela" name="cve_turno_escuela"  class="form-control" required>
                                                    <option value="" selected> -- SELECCIONA EL TURNO -- </option>
                                                    @foreach ($turnos as $turno)
                                                        <option value={{ $turno->cve_turno }} {{ $turno->cve_turno == $estudiante->cve_turno_escuela ? 'selected' : '' }}>{{ $turno->turno }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cve_turno_escuela')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="ano_escolar" class="col-md-5 col-form-label text-md-right">{{ __('Año Escolar')}}</label>
                                            <div class="col-md-6">
                                                <select id="ano_escolar" name="ano_escolar"  class="form-control" required>
                                                    <option value="" selected> -- SELECCIONA EL AÑO -- </option>
                                                    <option value=1 {{ $estudiante->ano_escolar == 1 ? 'selected' : '' }}> PRIMERO </option>
                                                    <option value=2 {{ $estudiante->ano_escolar == 2 ? 'selected' : '' }}> SEGUNDO </option>
                                                    <option value=3 {{ $estudiante->ano_escolar == 3 ? 'selected' : '' }}> TERCERO </option>
                                                    <option value=4 {{ $estudiante->ano_escolar == 4 ? 'selected' : '' }}> CUARTO </option>
                                                    <option value=5 {{ $estudiante->ano_escolar == 5 ? 'selected' : '' }}> QUINTO </option>
                                                    <option value=6 {{ $estudiante->ano_escolar == 6 ? 'selected' : '' }}> SEXTO </option>
                                                </select>
                                                @error('ano_escolar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="promedio" class="col-md-5 col-form-label text-md-right">{{ __('Promedio Actual') }}</label>
                                            <div class="col-md-6">
                                                <input id="promedio" name="promedio" type="number" step="0.1" min="0.0" max="10.0" class="form-control @error('promedio') is-invalid @enderror" name="promedio" value="{{ old('promedio', $estudiante->promedio) }}" placeholder="Promedio del último ciclo cursado" autocomplete="promedio" required>
                                                @error('promedio')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>III. DOCUMENTACIÓN </b>
                                        </div>
                                        <br>
                                        {{-- ********************* CURP ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('CURP') }} </label>
                                            <div class="col-md-6">
                                               <div>
                                                    <a href="{{ "/img/curps/" . $estudiante->img_curp }}" title="Ver PDF" class="btn btn-danger"> <b> PDF </b></a> <a id="sel_archivo_curp" style="cursor:pointer" title="Cargar" class="btn btn-primary"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                </div>
                                                <div id="archivo_curp" style="font-size:13px" required></div>
                                            </div>
                                            <input class='file' type="file" style="display: none " class="form-control" name="img_curp" id="img_curp" accept=".pdf,.PDF" required>
                                        </div>
                                        <input id="curp_hidden" name="curp_hidden" type="hidden" value="{{ $estudiante->img_curp ?? '#curp#' }}">
                                        {{-- ********************* ACTA ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Acta de Nacimiento') }} </label>
                                            <div class="col-md-6">
                                                <div>
                                                    <a href="{{ "/img/actas/" . $estudiante->img_acta_nac }}" title="Ver PDF" class="btn btn-danger"> <b> PDF </b></a> <a id="sel_archivo_acta_nac" style="cursor:pointer"  title="Cargar" class="btn btn-primary"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                </div>
                                                <div id="archivo_acta_nac" style="font-size:13px" required></div>
                                            </div>
                                            <input class='file' type="file" style="display: none " class="form-control" name="img_acta_nac" id="img_acta_nac" accept=".pdf,.PDF" required>
                                        </div>
                                        <input id="acta_hidden" name="acta_hidden" type="hidden" value="{{ $estudiante->img_acta_nac ?? '#acta#' }}">
                                        {{-- ********************* COMPROBANTE ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Comprobante Domicilio') }} </label>
                                            <div class="col-md-6">
                                                <div>
                                                    <a href="{{ "/img/comprobantes/" . $estudiante->img_comprobante_dom }}" title="Ver PDF" class="btn btn-danger"> <b> PDF </b></a> <a id="sel_archivo_comprobante_dom" style="cursor:pointer" title="Cargar" class="btn btn-primary"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                </div>
                                                <div id="archivo_comprobante_dom" style="font-size:13px" required></div> 
                                            </div>
                                            <input class='file' type="file" style="display:none " class="form-control" name="img_comprobante_dom" id="img_comprobante_dom" accept=".pdf,.PDF" required>
                                        </div>
                                        <input id="comprobante_hidden" name="comprobante_hidden" type="hidden" value="{{ $estudiante->img_comprobante_dom ?? '#comprobante#' }}">
                                        {{-- ********************* IDENTIFICACIÓN ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Identificación Oficial') }} </label>
                                            <div class="col-md-6">
                                                <div>
                                                    <a href="{{ "/img/identificaciones/" . $estudiante->img_identificacion }}" title="Ver PDF" class="btn btn-danger"> <b> PDF </b></a> <a id="sel_archivo_identificacion" style="cursor:pointer" title="Cargar" class="btn btn-primary"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                </div>
                                                <div id="archivo_identificacion" style="font-size:13px" required></div>
                                            </div>
                                            <input class='file' type="file" style="display:none " class="form-control" name="img_identificacion" id="img_identificacion" accept=".pdf,.PDF" required>
                                        </div>
                                        <input id="identificacion_hidden" name="identificacion_hidden" type="hidden" value="{{ $estudiante->img_identificacion ?? '#identificacion#' }}"> 
                                        {{-- ********************* KARDEX ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Kardex') }} </label>
                                            <div class="col-md-6">
                                                <div>
                                                    <a href="{{ "/img/kardex/" . $estudiante->img_kardex }}" title="Ver PDF" class="btn btn-danger"> <b> PDF </b></a> <a id="sel_archivo_kardex" style="cursor:pointer" title="Cargar" class="btn btn-primary"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                </div>
                                                 <div id="archivo_kardex" style="font-size:13px" required></div>
                                            </div>
                                            <input class='file' type="file" style="display:none " class="form-control" name="img_kardex" id="img_kardex" accept=".pdf,.PDF" required>
                                        </div>
                                        <input id="kardex_hidden" name="kardex_hidden" type="hidden" value="{{ $estudiante->img_kardex ?? '#kardex#' }}"> 
                                        {{-- ********************* CONSTANCIA ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Constancia de Estudios') }} </label>
                                            <div class="col-md-6">
                                                <div>
                                                    <a href="{{ "/img/constancias/" . $estudiante->img_constancia }}" title="Ver PDF" class="btn btn-danger"> <b> PDF </b></a> <a id="sel_archivo_constancia" style="cursor:pointer" title="Cargar" class="btn btn-primary"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                </div>
                                                 <div id="archivo_constancia" style="font-size:13px" required>
                                                </div>
                                            </div>
                                            <input class='file' type="file" style="display:none " class="form-control" name="img_constancia" id="img_constancia" accept=".pdf, .PDF" required>
                                        </div>
                                        <input id="constancia_hidden" name="constancia_hidden" type="hidden" value="{{ $estudiante->img_constancia ?? '#constancia#' }}"> 
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