<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoBipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_bip', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 10);
            $table->string('nombre', 50)->nullable();
            $table->string('entidad', 50);
            $table->string('direccion', 100);
            $table->string('comuna', 30);
            $table->decimal('lat', 10, 6);
            $table->decimal('lon', 10, 6);
            $table->smallInteger('servicios');
            $table->string('fuente', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('punto_bip');
    }
}
