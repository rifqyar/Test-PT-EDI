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
        Schema::create('M_Karyawan', function (Blueprint $table) {
            $table->integer('id_karyawan', true);
            $table->integer('id_user');
            $table->string('nama', 50);
            $table->string('no_ktp', 18)->nullable();
            $table->string('ttl', 75)->nullable();
            $table->integer('jk')->nullable();
            $table->integer('agama')->nullable();
            $table->string('gol_darah', 2)->nullable();
            $table->string('alamat', 150)->nullable();
            $table->string('no_telp', 15)->nullable();
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
        Schema::dropIfExists('M_Karyawan');
    }
};
