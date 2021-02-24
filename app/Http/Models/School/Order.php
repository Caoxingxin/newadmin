<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    //防止id取出为0
    public $incrementing = false;

    protected $fillable = [
        'id',
        'school_id',
        'semester_id',
        'student_id',
        'total',
        'privilege_total',
        'actual_total',
        'salesman_id',
        'type',
        'operator_id',
        'platform',
        'status',
        'remark',
    ];
}
