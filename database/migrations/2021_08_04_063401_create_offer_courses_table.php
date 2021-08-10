<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_courses', function (Blueprint $table) {
            $table->id();
            $table->string('class'); 
            $table->string('subject');
            $table->integer('class_type');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('day');
            $table->integer('student_limit');
            $table->integer('course_fee');
            $table->date('enrollment_last_date')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('offer_courses');
    }
}
