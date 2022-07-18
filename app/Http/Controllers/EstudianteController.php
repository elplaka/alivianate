<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Localidad;
use App\Models\Escuela;
use App\Models\Ciudad;
use App\Models\Turno;
use App\Models\Techo;
use App\Models\MontoMensual;
use App\Models\DatoSocioeconomico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;
use Dompdf\Dompdf;
use DOMDocument;

class EstudianteController extends Controller
{
    private function calcula_ano($ano_2dig)
    {
        $ano_abs = abs($ano_2dig);

        if ($ano_abs < 50) $ano = "20" . $ano_2dig;    //Nacieron en los 2000's
        else $ano = "19" . $ano_2dig;  //Nacieron en los 1900's

        return $ano;
    }

    private function esCURP($rfc)
    {
        $chars = str_split($rfc);

        if (ctype_upper($chars[0]) && ctype_upper($chars[1]) && ctype_upper($chars[2]) && ctype_upper($chars[3]))
        {
            if (is_numeric($chars[4]) && is_numeric($chars[5]) && is_numeric($chars[6]) && is_numeric($chars[7]) && is_numeric($chars[8]) && is_numeric($chars[9])) return true;
            else return false;
        }
        else return false;
    }

    private function generaRfcAleatorio($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function sacaRFC($img_curp)
    {
        $nomArchivo = '_' . $this->generaRfcAleatorio(9);
        $archivo = $nomArchivo . '.' . $img_curp->getClientOriginalExtension();
        $img_curp->move('img/tmp', $archivo);
        $bandera = "#curp#";

        //Lee el archivo PDF y separa por párrafos
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile('img/tmp/' . $archivo);
        $text = $pdf->getText();
        $parr = explode("\n", $text);

        $max_key = array_key_last($parr);  //Obtiene la última clave de un array

        if ($max_key < 11)  //Si no hubo 11 párrafos entonces no es un pdf de curp de los recientes
        {
            $rfc = $nomArchivo;
            rename('img/tmp/' . $archivo, 'img/curps/' . 'CU_' . $rfc . '.pdf');
            return $bandera;
        }
        else
        {
            $curp = $parr[11];
            $rfc = substr($curp, 0, 10);
            if ($this->esCURP($rfc)) 
            {
                rename('img/tmp/' . $archivo, 'img/curps/' . 'CU_' . $rfc . '.pdf');
                return $rfc;
            }
            else
            {
                $rfc = $nomArchivo;
                rename('img/tmp/' . $archivo, 'img/curps/' . 'CU_' . $rfc . '.pdf');
                return $rfc;
            }
        }
    }

    private function esValidoArchivoCURP($img_curp, &$rfc, $fileCurp)
    {
        if ($fileCurp) $rfc = $this->sacaRFC($img_curp); //Si se cargó el archivo en el input copia pdf y saca rfc
        else return false;

        $primer_car = substr($rfc,0,1);
        if (!isset($rfc) ||  $primer_car == '_') return false;
        else return true;
    }

    public function forget(Request $request)
    {
        $request->session()->forget('estudiante');
        $request->session()->forget('socioeconomico');
        $request->session()->forget('f1');
        $request->session()->forget('f2');
        $request->session()->forget('f3');
        $request->session()->forget('f4');
        $request->session()->forget('fin');

        return redirect()->route('estudiantes.formulario1');
    }
     /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function formulario1(Request $request)
    {
        $request->session()->put('f1', true);
        $request->session()->put('f2', false);
        $request->session()->put('f3', false);
        $request->session()->put('f4', false);
        $request->session()->put('fin', false);

        $estudiante = $request->session()->get('estudiante');
        return view('estudiantes/formulario1',compact('estudiante'));
    }
  
    /**  
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function formulario1Post(Request $request)
    {
        $validatedData = $request->validate([
            'img_curp' => ['required_with:alpha_dash', 'max:2000'],
            'img_acta_nac' => ['required_with:alpha_dash', 'max:2000'],
            'img_comprobante_dom' => ['required_with:alpha_dash', 'max:2000'],
            'img_identificacion' => ['required_with:alpha_dash', 'max:2000'],
            'img_kardex' => ['required_with:alpha_dash', 'max:2000'],
            'img_constacia' => ['required_with:alpha_dash', 'max:2000'],
        ]);

        $actaCargada = false;
        $comprobanteCargado = false;
        $identificacionCargada = false;
        $kardexCargado = false;
        $constanciaCargada = false;

        $estudiante = $request->session()->get('estudiante');

        if (isset($request->img_acta_nac) || (isset($estudiante) && $estudiante->img_acta_nac == "ACTA_OK.pdf")) $actaCargada = true;
        if (isset($request->img_comprobante_dom) || (isset($estudiante) && $estudiante->img_comprobante_dom == "COMPROBANTE_OK.pdf")) $comprobanteCargado = true;
        if (isset($request->img_identificacion) || (isset($estudiante) && $estudiante->img_identificacion == "ID_OK.pdf")) $identificacionCargada = true;
        if (isset($request->img_kardex) || (isset($estudiante) && $estudiante->img_kardex == "KARDEX_OK.pdf")) $kardexCargado = true;
        // if (isset($request->img_constancia) || (isset($estudiante) && $estudiante->img_constancia == "CONSTANCIA_OK.pdf")) $constanciaCargada = true;

        if (isset($request->img_curp)) $fileCurp = true;
        else $fileCurp = false;
        
        if ($actaCargada) $extActa = "pdf";
        else $extActa = substr(strrchr($request->acta_hidden, "."), 1);
        if ($comprobanteCargado) $extComprobante = "pdf";
        else $extComprobante = substr(strrchr($request->comprobante_hidden, "."), 1);
        if ($identificacionCargada) $extIdentificacion = "pdf";
        else $extIdentificacion = substr(strrchr($request->identificacion_hidden, "."), 1);
        if ($kardexCargado) $extKardex = "pdf";
        else $extKardex = substr(strrchr($request->kardex_hidden, "."), 1);
        // if ($constanciaCargada) $extConstancia = "pdf";
        // else $extConstancia = substr(strrchr($request->constancia_hidden, "."), 1);

        $message = '<b>INFORMACIÓN FALTANTE: </b> <ul>';
        $errorActa = false;
        $errorComprobante = false;
        $errorIdentificacion = false;
        $errorKardex = false;
        $errorConstancia = false;

        if (!$actaCargada && $request->acta_hidden == "#acta#")
        {
            $message = $message . "<li>El <b>ACTA DE NACIMIENTO</b> es obligatoria.</li>";
            $errorActa = true;
        }
        if (!$comprobanteCargado && $request->comprobante_hidden == "#comprobante#")
        {
            $message = $message . "<li>El <b>COMPROBANTE DE DOMICILIO</b> es obligatorio.</li>";
            $errorComprobante = true;
        }
        if (!$identificacionCargada && $request->identificacion_hidden == "#identificacion#")
        {
            $message = $message . "<li>La <b>IDENTIFICACIÓN OFICIAL</b> es obligatoria.</li>";
            $errorIdentificacion = true;
        }
        if (!$kardexCargado && $request->kardex_hidden == "#kardex#")
        {
            $message = $message . "<li>El <b>KARDEX</b> es obligatorio.</li>";
            $errorKardex = true;
        }
        // if (!$constanciaCargada && $request->constancia_hidden == "#constancia#")
        // {
        //     $message = $message . "<li>La <b>CONSTANCIA</b> es obligatoria.</li>";
        //     $errorConstancia = true;
        // }
        $message = $message . "</ul>";

        if ($this->esValidoArchivoCURP($request->img_curp, $rfc, $fileCurp)) //Valida que el PDF cargado sea el esperado
        {
            if(empty($request->session()->get('estudiante')))
            {
                $estudiante = new Estudiante();
                $estudiante->img_curp = "CURP_OK.pdf";
                if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                $estudiante->rfc = $rfc;
                $estudiante->cve_localidad_origen = 1;
                $estudiante->cve_localidad_actual = 1;
                $request->session()->put('estudiante', $estudiante);
            }
            else
            {
                $estudiante = $request->session()->get('estudiante');
                $estudiante->img_curp = "CURP_OK.pdf";
                if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                if ($fileCurp) $estudiante->rfc = $rfc;
                $rfc = $estudiante->rfc;
                $request->session()->put('estudiante', $estudiante);
            }
            $parser = new \Smalot\PdfParser\Parser();
            
            $pdf = $parser->parseFile('img/curps/CU_'. $rfc . ".pdf");
            $text = $pdf->getText();
            $parr = explode("\n", $text);

            $nombre_completo = explode(" ", $parr[12]);
            $max_key = array_key_last($nombre_completo);
            $nombre = '';
            for ($i=0; $i<=$max_key-2; $i++)
            {
                $nombre = $nombre . ' ' . $nombre_completo[$i];
            }
            $estudiante->nombre = trim($nombre);
            $estudiante->primer_apellido = trim($nombre_completo[$max_key-1]);
            $estudiante->segundo_apellido = trim($nombre_completo[$max_key]);

            $curp = $parr[11];
            $estudiante->curp = $curp;
            $dia_nac = substr($curp, 8, 2);
            $mes_nac = substr($curp, 6, 2);
            $ano_nac = $this->calcula_ano(substr($curp, 4, 2));

            $estudiante->fecha_nac = $ano_nac . '-' . $mes_nac . '-' . $dia_nac;

            //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
            if ($actaCargada) 
            {
                $archivo = 'AC_' . $rfc . '.' . $extActa;
                $request->img_acta_nac->move('img/actas', $archivo);
            }  
            if ($comprobanteCargado)
            {
                $archivo = 'CO_' . $rfc . '.' . $extComprobante;
                $request->img_comprobante_dom->move('img/comprobantes', $archivo);
            }
            if ($identificacionCargada)
            {
                $archivo = 'ID_' . $rfc . '.' . $extIdentificacion;
                $request->img_identificacion->move('img/identificaciones', $archivo);
            }
            if ($kardexCargado)
            {
                $archivo = 'KX_' . $rfc . '.' . $extKardex;
                $request->img_kardex->move('img/kardex', $archivo);
            }
            // if ($constanciaCargada)
            // {
            //     $archivo = 'CN_' . $rfc . '.' . $extConstancia;
            //     $request->img_constancia->move('img/constancias', $archivo);
            // }
            if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia) return redirect()->back()->with('message', $message);

            $request->session()->put('f2', true);
            return redirect()->route('estudiantes.formulario2');
        }
        else //Si no es válido el archivo PDF del CURP
        {
            if($fileCurp)  //Si se cargó el pdf en el input del CURP 
            {
                $estudiante = new Estudiante();
               
                //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
                if ($actaCargada) 
                {
                    if ($estudiante->img_acta_nac != "ACTA_OK.pdf")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'AC_' . $rfc . '.' . $extActa;
                        $request->img_acta_nac->move('img/actas', $archivo);
                    }
                }  
                if ($comprobanteCargado)
                {
                    if ($estudiante->img_comprobante_dom != "COMPROBANTE_OK.pdf")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'CO_' . $rfc . '.' . $extComprobante;
                        $request->img_comprobante_dom->move('img/comprobantes', $archivo);
                    }
                }
                if ($identificacionCargada)
                {
                    if ($estudiante->img_identificacion != "ID_OK.pdf")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'ID_' . $rfc . '.' . $extIdentificacion;
                        $request->img_identificacion->move('img/identificaciones', $archivo);
                    }
                }
                if ($kardexCargado)
                {
                    if ($estudiante->img_kardex != "KARDEX_OK.pdf")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'KX_' . $rfc . '.' . $extKardex;
                        $request->img_kardex->move('img/kardex', $archivo);
                    }
                }
                // if ($constanciaCargada)
                // {
                //     if ($estudiante->img_constancia != "CONSTANCIA_OK.pdf")  //Si no se había subido el archivo previamente
                //     {
                //         $archivo = 'CN_' . $rfc . '.' . $extConstancia;
                //         $request->img_constancia->move('img/constancias', $archivo);
                //     }
                // }

                $estudiante = $request->session()->get('estudiante');
                if (!isset($estudiante)) $estudiante = new Estudiante();
                $estudiante->img_curp = "CURP_OK.pdf";
                if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                $estudiante->rfc = $rfc;
                $estudiante->cve_localidad_origen = 1;
                $estudiante->cve_localidad_actual = 1;
                $request->session()->put('estudiante', $estudiante);

                if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia) return redirect()->back()->with('message', $message);

                $request->session()->put('f2', true);
                return redirect()->route('estudiantes.formulario2');                  
            }
            else  //Indica que en esta ocasión no se cargó el CURP en el input el archivo pero...
            {
                if (isset($estudiante) && strlen($estudiante->rfc) == 10) $rfc = $estudiante->rfc;  //Si ya se extrajo el rfc del pdf
                else $rfc = "probando123"; //Si no es un archivo de curp pdf válido va a tomar otro rfc
                
                if (isset($estudiante) && $estudiante->img_curp == 'CURP_OK.pdf')  //Significa que ya se había cargado el archivo del CURP previamente
                {
                    //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
                    if ($actaCargada) 
                    {
                        if ($estudiante->img_acta_nac != "ACTA_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'AC_' . $rfc . '.' . $extActa;
                            $request->img_acta_nac->move('img/actas', $archivo);
                        }
                    }  
                    if ($comprobanteCargado)
                    {
                        if ($estudiante->img_comprobante_dom != "COMPROBANTE_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'CO_' . $rfc . '.' . $extComprobante;
                            $request->img_comprobante_dom->move('img/comprobantes', $archivo);
                        }
                    }
                    if ($identificacionCargada)
                    {
                        if ($estudiante->img_identificacion != "ID_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'ID_' . $rfc . '.' . $extIdentificacion;
                            $request->img_identificacion->move('img/identificaciones', $archivo);
                        }
                    }
                    if ($kardexCargado)
                    {
                        if ($estudiante->img_kardex != "KARDEX_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'KX_' . $rfc . '.' . $extKardex;
                            $request->img_kardex->move('img/kardex', $archivo);
                        }
                    }
                    // if ($constanciaCargada)
                    // {
                    //     if ($estudiante->img_constancia != "CONSTANCIA_OK.pdf")  //Si no se había subido el archivo previamente
                    //     {
                    //         $archivo = 'CN_' . $rfc . '.' . $extConstancia;
                    //         $request->img_constancia->move('img/constancias', $archivo);
                    //     }
                    // }

                    // if(empty($request->session()->get('estudiante')))
                    // {
                    //     $estudiante = new Estudiante();
                    //     if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                    //     if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                    //     if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                    //     if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                    //     // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                    //     $request->session()->put('estudiante', $estudiante);
                    // }
                    // else
                    // {
                        $estudiante = $request->session()->get('estudiante');
                        if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                        if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                        if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                        if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                        // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                        $request->session()->put('estudiante', $estudiante);
                    // }

                    if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia) return redirect()->back()->with('message', $message);

                    $request->session()->put('f2', true);
                    return redirect()->route('estudiantes.formulario2');  
                }
                else return redirect()->back()->with('message', '¡ERROR! :: Primeramente selecciona el <b>archivo PDF del CURP</b>');
            }
            // if ($fileCurp) return redirect()->back()->with('message', 'Error en el archivo PDF del CURP. Intente subiendo otro archivo.');
            // else return redirect()->back()->with('message', '¡ERROR! :: Selecciona el <b>archivo PDF del CURP</b>');
        }
    }

    public function formulario2(Request $request)
    {
        $f2 = $request->session()->get('f2');

        if ($f2)
        {
            $localidades = Localidad::orderBy('localidad', 'ASC')->get();
            $estudiante = $request->session()->get('estudiante');
            return view('estudiantes/formulario2', compact('estudiante', 'localidades'));
        }
        else return view('estudiantes/operacion_invalida');
    }

    public function formulario2Post(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => ['required', 'max:20'],
            'primer_apellido' => ['required', 'max:20'],
            'segundo_apellido' => ['required', 'max:20'],
            'curp' => ['required', 'unique:estudiantes', 'min:18', 'max:18'],
            'fecha_nac' => ['required'],
            'celular' => ['required', 'digits:10'],
            'email' => ['required', 'max:40'],
            'cve_localidad_origen' => ['required'],
            'cve_localidad_actual' => ['required'],
        ]);

        $validatedData = $request->except(['nombre', 'primer_apellido', 'segundo_apellido', 'email']);  //Se exceptúan porque se van a cambiar a mayúsculas después
        $nombre = trim(mb_strtoupper($request->nombre));
        $primer_apellido = trim(mb_strtoupper($request->primer_apellido));
        $segundo_apellido = trim(mb_strtoupper($request->segundo_apellido));
        $email = trim(mb_strtolower($request->email));

        $estudiante = $request->session()->get('estudiante');
        $estudiante->fill($validatedData);
        $estudiante->nombre = $nombre;
        $estudiante->primer_apellido = $primer_apellido;
        $estudiante->segundo_apellido = $segundo_apellido;
        $estudiante->email = $email;
        $request->session()->put('estudiante', $estudiante);

        $request->session()->put('f3', true);
        return redirect()->route('estudiantes.formulario3');
    }


    public function formulario3(Request $request)
    {
        $f3 = $request->session()->get('f3');

        if ($f3)
        {
            // $escuelas = Escuela::orderBy('escuela', 'ASC')->get();
            $escuelas = Escuela::where('cve_escuela', '!=', '999')->orderBy('escuela', 'ASC')->get();
            $ciudades = Ciudad::all();
            $turnos = Turno::all();
            $estudiante = $request->session()->get('estudiante');
            return view('estudiantes/formulario3', compact('estudiante', 'escuelas', 'ciudades', 'turnos'));
        }
        else return view('estudiantes/operacion_invalida');
    }

    public function formulario3Post(Request $request)
    {
        $validatedData = $request->validate([
            'cve_ciudad_escuela' => ['required'], 
            'cve_escuela' => ['required'],        
            'cve_turno_escuela' => ['required'],  
            'carrera' => ['required', 'max:30'] ,             
            'ano_escolar' => ['required'],         
            'promedio' => ['required', 'numeric', 'between:0,10.0'],            
        ]);

        $validatedData = $request->except('carrera');  //Se exceptúa CARRERA porque se va a cambiar a mayúsculas después
        $carrera = trim(mb_strtoupper($request->carrera));

        $estudiante = $request->session()->get('estudiante');
        $estudiante->fill($validatedData);  //Se llena ESTUDIANTE con todos los campos validados excepto CARRERA
        $estudiante->carrera = $carrera;

        $request->session()->put('estudiante', $estudiante);
        $request->session()->put('f4', true);
        return redirect()->route('estudiantes.formulario4');
    }

    public function formulario4(Request $request)
    {
        $f4 = $request->session()->get('f4');

        $socioeconomico = $request->session()->get('socioeconomico');
        $techos = Techo::all();
        $montos = MontoMensual::all();
        if ($f4) return view('estudiantes/formulario4', compact('socioeconomico','techos', 'montos'));
        else return view('estudiantes/operacion_invalida');  
    }

    public function formulario4Post(Request $request)
    {
        $validatedData = $request->validate([
            'cve_techo_vivienda' => ['required'], 
            'cuartos_vivienda' => ['required', 'numeric', 'between:1,20'],        
            'personas_vivienda' => ['required', 'numeric', 'between:1,20'],
            'cve_monto_mensual' => ['required'] ,
            'beca_estudios' => ['required'] ,             
            'apoyo_gobierno' => ['required'],         
            'empleo' => ['nullable', 'max:30'], 
            'gasto_transporte' => ['required', 'numeric', 'between:0,1000'],             
        ]);
        $validatedData = $request->except('empleo');  //Se exceptúa EMPLEO porque se va a cambiar a mayúsculas después
        $empleo = trim(mb_strtoupper($request->empleo));

        $estudiante = $request->session()->get('estudiante');
        $rfc = $estudiante->rfc;
        $estudiante->img_curp =             'CU_' . $rfc . '.pdf';
        $estudiante->img_acta_nac =         'AC_' . $rfc . '.pdf';
        $estudiante->img_comprobante_dom =  'CO_' . $rfc . '.pdf';
        $estudiante->img_identificacion =   'ID_' . $rfc . '.pdf';
        $estudiante->img_kardex =           'KX_' . $rfc . '.pdf';
        //$estudiante->img_constancia =       'CN_' . $rfc . '.pdf';

        $time_int = time() * 999;
        $time_str = strval($time_int);
        $time_hex = dechex($time_str);
        $estudiante->id_hex = $time_hex;

        $request->session()->put('estudiante', $estudiante);
        DB::beginTransaction();
        try
        {
            $estudiante->save();

            $id_estudiante = DB::getPdo()->lastInsertId();   //Obtiene el ID recién guardado 
            if(empty($request->session()->get('socioeconomico')))
            {
                $socioeconomico = new DatoSocioeconomico;
                $socioeconomico->fill($validatedData);
                $socioeconomico->id_estudiante = $id_estudiante;
            }
            else
            {
                $socioeconomico = $request->session()->get('socioeconomico');
                $socioeconomico->fill($validatedData);
            }

            $socioeconomico->empleo = $empleo;
            $request->session()->put('socioeconomico', $socioeconomico);
            $socioeconomico->save();

            DB::commit();

            $request->session()->put('fin', true);
            return redirect()->route('estudiantes.mail_confirmacion', $estudiante->id);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function formulario_enviado(Request $request)
    {
        $fin = $request->session()->get('fin');

        //// $request->session()->forget('estudiante');
        //// $request->session()->forget('socioeconomico');

        $request->session()->forget('f1');
        $request->session()->forget('f2');
        $request->session()->forget('f3');
        $request->session()->forget('f4');
        //// $request->session()->forget('fin');

        if ($fin) return view('estudiantes/formulario_enviado');
        else return view('estudiantes/operacion_invalida');
    }

    public function registro_pdf(Request $request)
    {
        $estudiante = $request->session()->get('estudiante');
        $id_estudiante = $estudiante->id;

        $estudiante = Estudiante::where('id', $id_estudiante)->first();
        $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
        $pdf = PDF::loadView('estudiantes.registro_pdf',['estudiante'=>$estudiante, 'socioeconomico'=>$socioeconomico]);
        $pdf->setPaper("Letter", "portrait");
        return $pdf->stream('alivianate.pdf');

        return view('estudiantes.registro_pdf');
    }

    public function registro_pdf_post($id_hex)
    {
        $estudiante = Estudiante::where('id_hex', $id_hex)->first();
        if (isset($estudiante))
        {
            $id_estudiante = $estudiante->id;
            $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
            $pdf = PDF::loadView('estudiantes.registro_pdf',['estudiante'=>$estudiante, 'socioeconomico'=>$socioeconomico]);
            $pdf->setPaper("Letter", "portrait");
            return $pdf->stream('alivianate.pdf');
            return view('estudiantes.registro_pdf');
        }
        else return view('estudiantes/operacion_invalida');     
    }

    public function registro($id_hex)
    {
        $estudiante = Estudiante::where('id_hex', $id_hex)->first();
        if (isset($estudiante))
        {
            $id_estudiante = $estudiante->id;
            $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
            return view('estudiantes.registro', compact('estudiante', 'socioeconomico'));
        }
        else return view('estudiantes/operacion_invalida'); 
    }
 }
