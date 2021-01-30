<?php


namespace App\Http\Models\School;

use Illuminate\Database\Eloquent\Model;

class StudentDistribute extends Model
{
    protected $table = "student_distribute";

    protected $fillable = [
        'id',
        'student_id',
        'class_id',
        'operator_id',
    ];
}
