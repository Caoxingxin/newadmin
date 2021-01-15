<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semester', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->comment('学校');
            $table->string('name', 100)->comment('名称');
            $table->string('picture')->nullable()->comment('图片');
            $table->date('start_date')->comment('培训开始时间');
            $table->date('end_date')->comment('培训结束时间');
            $table->string('contact', 20)->nullable()->comment('联系电话');
            $table->string('wechat', 100)->nullable()->comment('微信号');
            $table->date('register_start_at')->comment('报名开始时间');
            $table->date('register_end_at')->comment('报名结束时间');
            $table->smallInteger('number')->default(0)->comment('报名名额');
            $table->smallInteger('registered_number')->comment('已报名人数')->nullable();
            $table->decimal('tuition', 10, 2)->comment('学费')->default(0);
            $table->mediumText('introduction')->nullable()->comment('学期介绍');
            $table->tinyInteger('status')->comment('状态:1上线 -1下线')->default(-1);
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
        Schema::dropIfExists('semester');
    }
}
