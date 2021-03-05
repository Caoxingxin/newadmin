<?php


namespace App\Http\Models\Classes;


use Illuminate\Database\Eloquent\Model;

class CoursePlan extends Model
{
    protected $table = 'course_plan';

    protected $fillable = [
        'id',
        'class_id',
        'course_id',
        'teacher_id',
        'classroom_id',
        'max_number',
        'start_at',
        'end_at',
        'status',
        'operator_id',
    ];
}
