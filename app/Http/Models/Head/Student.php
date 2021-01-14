<?php


namespace App\Http\Models\Head;


use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "student";

    protected $fillable = [
        'id',
        'name',
        'mobile',
        'email',
        'gender',
        'status',
        'degree',
        'company',
        'remark',
        'avatar',
        'introduction',
    ];
}
