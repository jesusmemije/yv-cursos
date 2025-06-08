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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('creator_user_id');
            $table->string('title');
            $table->string('slug');
            $table->mediumText('details');
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('time_zone');
            $table->tinyInteger('status')->default(0)->comment('1=published, 0=unpublished');
            $table->unsignedBigInteger('event_category_id')->nullable();
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
        Schema::dropIfExists('events');
    }
};
