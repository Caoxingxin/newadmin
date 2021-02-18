<?php


namespace App\Http\Constans\School;


class StudentRegisterStatus
{
    const NOT_REGISTER = 10;    //未报到
    const REGISTER = 20;    //已报到
    const DELAY = 30;    //延期
    const COMPLETE = 40;    //已结业
    const CANCELLED = 50;    //已取消
}
