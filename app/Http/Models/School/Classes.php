<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'class';

    protected $fillable = [
        'school_id',
        'semester_id',
        'name',
        'operate_id',
        'status'
    ];
}
