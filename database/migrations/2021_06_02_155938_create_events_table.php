<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('gambar')->nullable();
            $table->text('deskripsi');
            $table->bigInteger('admin_id')->unsigned();
            $table->date('date_start');
            $table->date('date_end');
            $table->string('time_start', 20);
            $table->string('time_end', 20);
            $table->string('lokasi', 100);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
