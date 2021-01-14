<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32);
            $table->string('mobile',11)->nullable();
            $table->string('picture')->nullable()->comment('头像');
            $table->tinyInteger('gender')->comment('性别');
            $table->date('entry_time')->comment('入职日期');
            $table->date('full_time')->nullable()->comment('转正日期');
            $table->tinyInteger('status')->default(10)->comment('状态 10.试用期  20.正式员工');
            $table->string('address', 100)->nullable()->comment('住址');
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
        Schema::dropIfExists('teacher');
    }
}
