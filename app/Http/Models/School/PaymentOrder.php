<?php


namespace App\Http\Models\School;


use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    protected $table = 'payment_order';

    //防止id取出为0
    public $incrementing = false;

    protected $fillable = [
        'id',
        'relation_id',
        'school_id',
        'student_id',
        'type',
        'channel',
        'amount',
        'status',
        'trade_no',
        'extra',
        'platform'
    ];
}
