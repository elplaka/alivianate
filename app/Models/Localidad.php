<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'localidades';

    protected $primaryKey = 'cve_localidad';

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
