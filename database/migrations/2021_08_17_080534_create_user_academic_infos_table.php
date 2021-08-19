<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAcademicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_academic_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_info_id');
            $table->integer('user_academic_type')->nullable();
            $table->integer('user_class')->nullable();
            $table->string('user_institute_name')->nullable();
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
        Schema::dropIfExists('user_academic_infos');
    }
}
