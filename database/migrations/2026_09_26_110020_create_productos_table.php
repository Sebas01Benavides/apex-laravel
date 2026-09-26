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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 40)->unique();
            $table->text('descripcion');
            $table->string('categoria', 60);
            $table->string('marca', 60);
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->decimal('costo', 10, 2)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('estado', 20)->default('Activo');
            $table->string('tipo', 50)->nullable();
            $table->integer('stock')->default(0);
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
