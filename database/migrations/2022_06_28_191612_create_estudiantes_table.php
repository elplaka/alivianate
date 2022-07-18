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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',20);
            $table->string('primer_apellido',20);
            $table->string('segundo_apellido',20);
            $table->string('curp',18);
            $table->string('rfc',10);
            $table->date('fecha_nac');
            $table->string('celular',10);
            $table->string('email',40);
            $table->integer('cve_localidad_origen')->unsigned();
            $table->integer('cve_localidad_actual')->unsigned();
            $table->integer('cve_ciudad_escuela')->unsigned();
            $table->integer('cve_escuela')->unsigned();
            $table->integer('cve_turno_escuela')->unsigned();
            $table->string('carrera',30);
            $table->integer('ano_escolar');
            $table->float('promedio');
            $table->string('img_curp',17);
            $table->string('img_acta_nac',17);
            $table->string('img_comprobante_dom',17);
            $table->string('img_identificacion',17);
            $table->string('img_kardex',17);            
            $table->timestamps();

            $table->foreign('cve_localidad_origen')
            ->references('cve_localidad')
            ->on('localidades')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cve_localidad_actual')
            ->references('cve_localidad')
            ->on('localidades')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cve_escuela')
            ->references('cve_escuela')
            ->on('escuelas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cve_ciudad_escuela')
            ->references('cve_ciudad')
            ->on('ciudades')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cve_turno_escuela')
            ->references('cve_turno')
            ->on('turnos')
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
        Schema::dropIfExists('estudiantes');
    }
};
