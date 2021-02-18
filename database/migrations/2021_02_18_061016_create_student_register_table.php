<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_register', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('生成单号');
            $table->Integer('student_id')->comment('学员');
            $table->Integer('semester_id')->comment('学期');
            $table->Integer('class_id')->comment('班级')->nullable();
            $table->tinyInteger('status')->comment('报到状态:10未报到 20已报到 30延期')->default(10);
            $table->tinyInteger('audit')->comment('审核成绩状态：未通过-10 通过 10')->default(-10);
            $table->decimal('tuition', 10, 2)->comment('学费')->default(0);
            $table->decimal('earnest_paid', 10, 2)->comment('支付定金')->nullable()->default(0);
            $table->decimal('tuition_paid', 10, 2)->comment('支付学费')->nullable()->default(0);
            $table->decimal('deposit_paid', 10, 2)->comment('支付押金')->nullable()->default(0);
            $table->decimal('tuition_refund', 10, 2)->comment('学费退款')->nullable()->default(0);
            $table->decimal('deposit_refund', 10, 2)->comment('押金退款')->nullable()->default(0);
            $table->Integer('admin_id')->comment('销售员')->nullable();
            $table->string('remark')->comment('备注')->nullable();
            $table->Integer('operator_id')->comment('操作人:记录状态修改操作人')->nullable();
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
        Schema::dropIfExists('student_register');
    }
}
