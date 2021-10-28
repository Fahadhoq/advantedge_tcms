<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('payment_amount');
            $table->integer('payment_type');
            $table->integer('payment_mobile_number')->nullable();
            $table->integer('payment_transaction_number')->nullable();
            $table->integer('cheque_transit_number')->nullable();
            $table->string('payment_remark')->nullable();
            $table->date('payment_date');
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
        Schema::dropIfExists('student_payments');
    }
}
