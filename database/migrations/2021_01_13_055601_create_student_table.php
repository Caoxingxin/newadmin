<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32);
            $table->string('mobile',11);
            $table->string('email',32)->nullable()->comment('邮箱');
            $table->tinyInteger('gender')->comment('性别');
            $table->tinyInteger('status')->comment('状态，10潜在、20学员、30毕业');
            $table->integer('degree')->nullable()->comment('注册等级：10普通、20高级');
            $table->string('company',100)->nullable()->comment('工作单位');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('remark',255)->nullable()->comment('备注');
            $table->text('introduction')->nullable()->comment('简介');
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
        Schema::dropIfExists('student');
    }
}
