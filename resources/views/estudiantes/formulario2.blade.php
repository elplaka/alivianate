<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <title>ALIVIAN4TE - Por tiempos mejores </title>
    
        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    
        <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">  
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
            trigger : 'click'
            })
            $('[data-toggle="tooltip"]').mouseleave(function(){
            $(this).tooltip('hide');
            });    
        });
    });
</script>

<style>
    .tooltip-inner {
    max-width: 350px;
    /* If max-width does not work, try using width instead */
    width: 350px; 
    max-height: 120px;
    background-color: #2f4fff;
    text-align: left;
}
</style>
</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center mb-4">
                        <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario2.post') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <img src="../img/alivianate.jpg" style="width:45%">
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('FORMULARIO DE REGISTRO') }} </b> </h1>
                                </div>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>2. INFORMACIÓN PERSONAL</b>
                                        </div>
                                        <br>
                                        <div>
                                            @if (session()->has('message'))
                                            <div class="alert alert-danger mb-0">                        
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button>                        
                                                {!! html_entity_decode(session()->get('message')) !!}
                                            </div> 
                                            @endif 
                                        </div>
                                        <div class="card-body">
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
                                                <div class="col-md-6">
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
                                                <label for="email" class="col-md-5 col-form-label text-md-right">{{ __('E-mail') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CORREO ELECTRÓNICO VÁLIDO</b> <br> Debes registrar un e-mail existente y al que puedas acceder porque al finalizar este formulario se te enviará un archivo importante para este proceso."><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
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
                                                <label for="cve_localidad_origen" class="col-md-5 col-form-label text-md-right">{{ __('Lugar de Origen') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>LUGAR DONDE CRECISTE</b> <br> Selecciona una localidad del municipio de Concordia donde hayas vivido hasta antes de entrar a la universidad."><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-6">
                                                    <select id="cve_localidad_origen" name="cve_localidad_origen" class="form-control" aria-label="Default select example">
                                                        @foreach ($localidades as $localidad)
                                                            <option value="{{ $localidad->cve_localidad }}" {{ $localidad->cve_localidad == $estudiante->cve_localidad_origen? 'selected' : '' }}>{{ $localidad->localidad }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="cve_localidad_actual" class="col-md-5 col-form-label text-md-right">{{ __('Lugar de Transporte') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>LUGAR DONDE TOMAS EL CAMIÓN</b> <br> Selecciona una localidad del municipio de Concordia desde donde partes (diariamente o semanalmente) a la universidad."><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
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
                                <a href="{{ route('estudiantes.formulario1') }}" class="next btn btn-info float-left mt-2">Anterior</a>
                                <button type="submit" id="btnSiguiente" name="btnSiguiente" class="next btn btn-info float-right mt-2">Siguiente</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> --}}
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>