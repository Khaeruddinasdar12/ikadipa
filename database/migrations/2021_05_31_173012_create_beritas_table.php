<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            // $table->string('slug')->unique();
            $table->string('gambar')->nullable();
            $table->text('isi');
            $table->bigInteger('admin_id')->unsigned();
            $table->string('kategori');
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins');
            // $table->foreign('kategori_id')->references('id')->on('kategori_beritas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beritas');
    }
}
