<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('class_id')->comment('班级');
            $table->integer('course_id')->comment('课程');
            $table->integer('teacher_id')->comment('教师');
            $table->integer('classroom_id')->comment('教室');
            $table->smallInteger('max_number')->comment('容纳人数');
            $table->datetime('start_at')->comment('培训开始时间');
            $table->datetime('end_at')->comment('培训结束时间');
            $table->tinyInteger('status')->default(20)->comment('状态:10已审核,20未审核,30已取消');
            $table->string('operator_id')->comment('操作人');
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
        Schema::dropIfExists('course_plan');
    }
}
