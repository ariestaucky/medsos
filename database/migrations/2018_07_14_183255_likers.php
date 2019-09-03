<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Likers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('likeable_id');
            $table->string('likeable_type');

            $table->unsignedInteger('liker_id')->nullable();
            $table->string('liker_type')->nullable();

            $table->timestamps();

            $table->foreign('likeable_id')
                    ->references('id')
                    ->on('posts')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('liker_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likers');
    }
}
