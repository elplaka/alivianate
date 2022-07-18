<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DatoSocioeconomico;

class Techo extends Model
{
    use HasFactory;

    protected $primaryKey = 'cve_techo';

    public function socioeconomico()
    {
        return $this->hasMany(DatoSocioEconomico::class);
    }
}
