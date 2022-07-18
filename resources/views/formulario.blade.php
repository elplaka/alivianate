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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
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

                $('#btnSiguiente').click(function(){
                    <?php $step = $step + 1; ?>
                });
            });

            $(function(){
                var $sections = $('.form-section');

                function navigateTo(index){
                    $sections.removeClass('current').eq(index).addClass('current');
                    $('.form-navigation .previous').toggle(index>0);
                    var atTheEnd = index >= $sections.length - 1;
                    $('.form-navigation .next').toggle(!atTheEnd);
                    $('.form-navigation [type=submit]').toggle(atTheEnd);
                }

                function curIndex()
                {
                    return $sections.index($sections.filter('.current'));
                }

                $('.form-navigation .previous').click(function(){
                    navigateTo(curIndex()-1);
                });

                $('.form-navigation .next').click(function(){
                    $('.contact-form').parsley().whenValidate({
                        group: 'block-' + curIndex()
                    }).done(function(){
                        navigateTo(curIndex()+1);
                    });
                });

                $sections.each(function(index, section){
                    $(section).find(':input').attr('data-parsley-group', 'block-' + index);
                });

                navigateTo(0);
            });
        </script>

        <style>
            .tooltip-inner {
            max-width: 350px;
            /* If max-width does not work, try using width instead */
            width: 350px; 
            max-height: 100px;
            background-color: #2f4fff;
            text-align: left;
}
        </style>
</head>
{{ $step }}
<body>
    <section>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div>
                        @if (session()->has('message'))
                        <div class="alert alert-success">                        
                            <button type="button" class="close" data-dismiss="alert">
                                x
                            </button>                        
                            {{ session()->get('message') }}
                        </div>                
                        @endif                    
                    </div>
                    <div class="row justify-content-center mb-4">
                        <img src="img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <img src="img/alivianate.jpg" style="width:45%">
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('FORMULARIO DE REGISTRO') }} </b> </h1>
                                </div>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>1. SUBIR DOCUMENTOS</b>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label class="col-md-5 col-form-label text-md-right">{{ __('CURP') }} <a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ARCHIVO EN PDF</b> <br> El formulario aceptará el archivo PDF descargado en la página del Gobierno Federal <i>https://www.gob.mx/curp/</i>"><img src="img/Help.jpg" style="width:12px"></a></label>
                                                <div class="col-md-7">
                                                    <input style="width:100%;font-size:15px;" type="file" id="curp_pdf" name="curp_pdf" accept="application/pdf" required> 
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-5 col-form-label text-md-right">{{ __('Acta de Nacimiento') }} <a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ACTA CON FORMATO RECIENTE</b> <br> El acta de nacimiento se recomienda que sea de formato reciente"><img src="img/Help.jpg" style="width:12px"></a></label>
                                                <div class="col-md-7">
                                                    <input style="width:100%;font-size:15px;" type="file" id="acta_nac" name="acta_nac" accept=".png, .jpg, .jpeg, .pdf" required> 
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-5 col-form-label text-md-right">{{ __('Comprobante Domicilio') }} <a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>COMPROBANTES VÁLIDOS</b> <br> <ul>
                                                    <li>Recibo de CFE</li>
                                                    <li>Recibo de JUMAPAC</li>
                                                    <li>Recibo de TELMEX</li>
                                                </ul>"><img src="img/Help.jpg" style="width:12px"></a></label> 
                                                <div class="col-md-7">
                                                    <input style="width:100%;font-size:15px;" type="file" id="comprobante_dom" name="comprobante_dom" accept=".png, .jpg, .jpeg, .pdf" required> 
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-5 col-form-label text-md-right">{{ __('Identificación Oficial') }} <a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>INE O ESCOLAR</b> <br> Si no tienes la credencial del INE entonces subirás una credencial escolar"><img src="img/Help.jpg" style="width:12px"></a></label>
                                                <div class="col-md-7">
                                                    <input style="width:100%;font-size:15px;" type="file" id="identificacion" name="identificacion" accept=".png, .jpg, .jpeg, .pdf" required> 
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-5 col-form-label text-md-right">{{ __('Kárdex') }} <a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE CALIFICACIONES O FICHA DE INSCRIPCIÓN</b> <br> Si apenas vas a entrar al Nivel Superior subirás la ficha de inscripción"><img src="img/Help.jpg" style="width:12px"></a></label>
                                                <div class="col-md-7">
                                                    <input style="width:100%;font-size:15px;" type="file" id="kardex" name="kardex" accept=".png, .jpg, .jpeg, .pdf" required> 
                                                </div>
                                            </div>
                                           </div>
                                    </div>
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>2. INFORMACIÓN PERSONAL</b>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                    
                                                <div class="col-md-7">
                                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" autocomplete="nombre" required autofocus>
                    
                                                    @error('nombre')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="primer_apellido" class="col-md-4 col-form-label text-md-right">{{ __('Primer Apellido') }}</label>
                    
                                                <div class="col-md-7">
                                                    <input id="primer_apellido" type="text" class="form-control @error('primer_apellido') is-invalid @enderror" name="primer_apellido" value="{{ old('primer_apellido') }}"  autocomplete="primer_apellido" autofocus>
                    
                                                    @error('primer_apellido')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>  
                                            <div class="row mb-3">
                                                <label for="segundo_apellido" class="col-md-4 col-form-label text-md-right">{{ __('Segundo Apellido') }}</label>
                    
                                                <div class="col-md-7">
                                                    <input id="segundo_apellido" type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" name="segundo_apellido" value="{{ old('segundo_apellido') }}"  autocomplete="segundo_apellido" autofocus>
                    
                                                    @error('segundo_apellido')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-navigation" style="padding: 2em 6em 2em 6em;">
                                        <button type="button" class="previous btn btn-info float-left">Anterior</button>
                                        <button type="button" id="btnSiguiente" name="btnSiguiente" class="next btn btn-info float-right">Siguiente</button>
                                        <button type="submit" class="btn btn-primary float-right">Guardar</button>
                                        {{-- <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Siguiente') }}
                                            </button>
                                        </div> --}}
                                    </div>   
                                </div>         
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>


    
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>