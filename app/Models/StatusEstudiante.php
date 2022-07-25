<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class StatusEstudiante extends Model
{
    use HasFactory;

    protected $table = 'status_estudiantes';

    protected $primaryKey = 'cve_status';

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
