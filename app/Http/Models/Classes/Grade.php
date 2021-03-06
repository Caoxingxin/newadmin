<?php


namespace App\Http\Models\Classes;


use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'student_grade';

    protected $fillable = [
        'id',
        'class_id',
        'student_id',
        'score',
        'operator_id',
        'course_id'
    ];
}
