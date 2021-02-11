<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maker_id');
            $table->foreignId('target_id');
            $table->foreignId('post_id');
            $table->char('type') -> nullable();  //comment 'c' or react 'r'
            $table->boolean('seen')->default(0); // if the notification seen
            $table->boolean('readed')->default(0); //if this preticular notification has been readed 
            $table->timestamps();

            $table->foreign('maker_id')->references('id')->on('users');
            $table->foreign('target_id')->references('id')->on('users');
            $table->foreign('post_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
