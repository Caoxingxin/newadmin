<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class StudentRegister extends Model
{
    protected $table = "student_register";

    protected $fillable = [
        'id',
        'student_id',
        'semester_id',
        'class_id',
        'status',
        'audit',
        'tuition',
        'earnest_paid',
        'tuition_paid',
        'deposit_paid',
        'tuition_refund',
        'deposit_refund',
        'admin_id',
        'remark',
        'operator_id',
    ];
}
