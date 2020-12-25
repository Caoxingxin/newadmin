<?php


namespace App\Http\Models\Head;


use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';

    protected $fillable = [
        'name',
        'name_en',
        'picture',
        'phone',
        'email',
        'address',
        'address_en',
        'description',
        'status'
    ];
}
