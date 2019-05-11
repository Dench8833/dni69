<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeySongs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('songs', function (Blueprint $table) {
            $table->unsignedInteger('album_id')->change();
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            $table->unsignedInteger('photo_id')->change();
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->unsignedInteger('lyrics_id')->change();
            $table->foreign('lyrics_id')->references('id')->on('lyrics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropForeign('songs_album_id_foreign');
            $table->dropForeign('songs_photo_id_foreign');
            $table->dropForeign('songs_lyric_id_foreign');
        });
    }
}
