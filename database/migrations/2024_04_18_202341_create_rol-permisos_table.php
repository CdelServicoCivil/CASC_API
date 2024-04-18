<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rol-permisos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rol_id')->unsigned();
            $table->bigInteger('permiso_id')->unsigned();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('rols');
            $table->foreign('permiso_id')->references('id')->on('permisos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol-permisos');
    }
};
