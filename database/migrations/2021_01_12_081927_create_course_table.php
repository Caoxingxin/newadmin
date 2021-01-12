<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32)->nullable()->comment('课程名');
            $table->string('type')->nullable()->comment('课程类型');
            $table->string('picture')->nullable()->comment('课程图片');
            $table->string('duration')->nullable()->comment('课程时长');
            $table->text('remark')->nullable()->comment('课程简介');
            $table->tinyInteger('status')->default(1)->comment('状态 1.正常  -1.禁用');
            $table->tinyInteger('examine')->default(1)->comment('状态 1.需要考试 0.不需要考试');
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
        Schema::dropIfExists('course');
    }
}
