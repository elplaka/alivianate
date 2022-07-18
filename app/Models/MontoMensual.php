<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DatoSocioeconomico;


class MontoMensual extends Model
{
    use HasFactory;

    protected $table = 'montos_mensuales';

    protected $primaryKey = 'cve_monto';

    public function socioeconomico()
    {
        return $this->hasMany(DatoSocioEconomico::class);
    }
}
