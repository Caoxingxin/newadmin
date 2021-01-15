<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $fillable = [
        'id',
        'school_id',
        'name',
        'picture',
        'start_date',
        'end_date',
        'contact',
        'wechat',
        'register_start_at',
        'register_end_at',
        'number',
        'registered_number',
        'register_mode',
        'tuition',
        'introduction',
        'status'
    ];
}
