<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class Student_School extends Model
{
    protected $table = "student_school";

    protected $fillable = [
        'id',
        'student_id',
        'school_id',
    ];
}
