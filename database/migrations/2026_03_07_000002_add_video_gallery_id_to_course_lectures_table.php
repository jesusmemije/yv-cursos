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
        Schema::table('course_lectures', function (Blueprint $table) {
            $table->unsignedBigInteger('video_gallery_id')->nullable()->after('lesson_id');
            $table->foreign('video_gallery_id')->references('id')->on('video_galleries')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_lectures', function (Blueprint $table) {
            $table->dropForeign(['video_gallery_id']);
            $table->dropColumn('video_gallery_id');
        });
    }
};
