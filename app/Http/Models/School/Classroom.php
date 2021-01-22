<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classroom';

    protected $fillable = [
        'school_id',
        'name',
        'max_number',
        'status'
    ];
}
