<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDistributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_distribute', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('class_id')->comment('班级id');
            $table->Integer('student_id')->comment('学员id');
            $table->Integer('operator_id')->comment('操作人id');
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
        Schema::dropIfExists('student_distribute');
    }
}
