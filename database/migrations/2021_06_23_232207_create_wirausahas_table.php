<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWirausahasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wirausahas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200);
            $table->bigInteger('kategori_id')->unsigned();
            $table->bigInteger('alamat_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('alamat_lengkap', 200);
            $table->string('lokasi', 200)->nullable();


            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('kategori_perusahaans');
            $table->foreign('alamat_id')->references('id')->on('kotas');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wirausahas');
    }
}
