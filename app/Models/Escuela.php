<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;


class Escuela extends Model
{
    use HasFactory;

    protected $primaryKey = 'cve_escuela';

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
