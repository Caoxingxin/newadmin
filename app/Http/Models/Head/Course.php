<?php


namespace App\Http\Models\Head;


use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "course";

    protected $fillable = [
        'id',
        'name',
        'type',
        'picture',
        'duration',
        'remark',
        'status',
        'examine'
    ];
}
