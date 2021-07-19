<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('stb');
            $table->string('username', 35)->unique();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('alamat', 100);
            $table->bigInteger('alamat_id')->unsigned();
            $table->string('nohp', 15);
            $table->bigInteger('jurusan_id')->unsigned();
            $table->enum('is_active', ['0','1', 'tolak']); // 0 inactive, 1 is_active

            //field pekerjaan
            $table->string('perusahaan', 35)->nullable(); //nama perusahaan
            $table->bigInteger('kategori_id')->unsigned()->nullable();
            $table->string('alamat_perusahaan', 100)->nullable();
            $table->bigInteger('alamat_perusahaan_id')->unsigned()->nullable();
            $table->string('jabatan', 20)->nullable();
            //end field perusahaan


            $table->string('komentar', 150)->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();

            // FK
            $table->foreign('alamat_id')->references('id')->on('kotas');
            $table->foreign('kategori_id')->references('id')->on('kategori_perusahaans');
            $table->foreign('jurusan_id')->references('id')->on('jurusans');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
