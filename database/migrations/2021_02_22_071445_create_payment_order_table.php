<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_order', function (Blueprint $table) {
            $table->bigInteger('id')->comment('支付订单号');
            $table->bigInteger('relation_id')->comment('关联订单');
            $table->Integer('school_id')->comment('学校')->nullable();
            $table->Integer('student_id')->comment('会员');
            $table->smallInteger('channel')->comment('支付方式:10现金 20余额 30微信支付 40支付宝, >=100后台线下支付');
            $table->decimal('amount', 10, 2)->comment('支付金额')->default(0);
            $table->tinyInteger('status')->comment('支付状态:0未支付 8支付中 10支付成功 -10支付失败');
            $table->string('trade_no', 30)->comment('交易号')->nullable();
            $table->json('extra')->comment('支付信息')->nullable();
            $table->tinyInteger('platform')->comment('下单渠道:1后台 2小程序 3App');
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
        Schema::dropIfExists('payment_order');
    }
}
