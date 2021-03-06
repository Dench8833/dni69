<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 255)->unique();
            $table->string('path', 255);
            $table->integer('size');
            $table->integer('album_id');
            $table->integer('photo_id')->nullable();;
            $table->integer('lyrics_id')->nullable();
            $table->text('description');
            $table->timestamp('uploaded');
            $table->timestamps();
            $table->timestamp('deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
