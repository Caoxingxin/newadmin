<?php


namespace App\Http\Models\Head;


use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = "teacher";

    protected $fillable = [
        'id',
        'name',
        'mobile',
        'picture',
        'gender',
        'entry_time',
        'full_time',
        'status',
        'address',
        'introduction'
    ];
}
