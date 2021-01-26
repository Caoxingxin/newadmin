<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id')->comment('学校');
            $table->integer('semester_id')->comment('学期');
            $table->string('name')->comment('名称');
            $table->integer('operate_id')->comment('操作人');
            $table->tinyInteger('status')->comment('状态: 1启用 -1禁用')->default(1);
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
        Schema::dropIfExists('class');
    }
}
