<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20)->comment('名称');
            $table->string('name_en', 30)->comment('英文姓名')->nullable();
            $table->string('picture')->comment('图片');
            $table->string('phone', 20)->comment('电话');
            $table->string('email', 30)->comment('邮箱')->nullable();
            $table->string('address', 100)->comment('详细地址');
            $table->string('address_en', 100)->comment('英文地址');
            $table->string('description')->comment('描述')->nullable();
            $table->tinyInteger('status')->comment('当前状态:10筹备中 20运营 -20暂停 默认10')->default(10)->nullable();
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
        Schema::dropIfExists('school');
    }
}
