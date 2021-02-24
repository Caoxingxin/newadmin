<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigInteger('id')->comment('生成单号');
            $table->Integer('school_id')->comment('学校')->nullable();
            $table->Integer('semester_id')->comment('学期')->nullable();
            $table->Integer('student_id')->comment('学员');
            $table->decimal('total', 10, 2)->comment('原价')->default(0);
            $table->decimal('actual_total', 10, 2)->comment('实际支付')->default(0);
            $table->tinyInteger('type')->comment('下单类型:10支付 -10退款');
            $table->Integer('operator_id')->comment('操作人')->nullable();
            $table->tinyInteger('platform')->comment('下单渠道:10后台 20小程序 30公众号');
            $table->tinyInteger('status')->comment('状态:0待付款 10已完成 -10已取消 8支付中');
            $table->string('remark')->comment('备注')->nullable();
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
        Schema::dropIfExists('order');
    }
}
