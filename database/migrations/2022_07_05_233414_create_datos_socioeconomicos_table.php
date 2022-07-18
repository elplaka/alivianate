<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_socioeconomicos', function (Blueprint $table) {
            $table->integer('id_estudiante')->primary();
            $table->integer('cve_techo_vivienda')->unsigned();
            $table->integer('cuartos_vivienda');
            $table->integer('personas_vivienda');
            $table->integer('cve_monto_mensual')->unsigned();
            $table->boolean('beca_estudios');
            $table->boolean('apoyo_gobierno');
            $table->string('empleo', 30)->default('NO')->nullable();
            $table->float('gasto_transporte');
            $table->timestamps();

            $table->foreign('cve_techo_vivienda')
            ->references('cve_techo')
            ->on('techos')
            ->onDelete('cascade')
            ->onUpdate('cascade');
    
            $table->foreign('cve_monto_mensual')
            ->references('cve_monto')
            ->on('montos_mensuales')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_socioeconomicos');
    }
};
