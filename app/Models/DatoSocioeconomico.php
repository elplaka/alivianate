<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\MontoMensual;

class DatoSocioeconomico extends Model
{
    use HasFactory;

    protected $table = 'datos_socioeconomicos';

    protected $primaryKey = 'id_estudiante';

    protected $fillable = [
        'id_estudiante',
        'cve_techo_vivienda',
        'cuartos_vivienda',
        'personas_vivienda',
        'cve_monto_mensual',
        'beca_estudios',
        'apoyo_gobierno',
        'empleo',
        'gasto_transporte',
        'observaciones'
    ];  

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function techo()
    {
        return $this->belongsTo(Techo::class, 'cve_techo_vivienda');
    }

    public function monto_mensual()
    {
        return $this->belongsTo(MontoMensual::class, 'cve_monto_mensual');
    }
}
