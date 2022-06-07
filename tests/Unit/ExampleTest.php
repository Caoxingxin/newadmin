<?php

namespace Tests\Unit;

use App\Events\Ceshi;
use App\Http\Models\Head\Course;
use App\Http\Models\Head\School;
use App\Http\Models\Head\Student;
use App\Http\Models\Head\Teacher;
use Caoxin\Test;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    //课程数据写入redis
    public function testCourseredis(){

        event(new Ceshi(123));
        dd(44);
        dd(445*2+468+500+450);

        $courseData = Course::query()->get();
        foreach ($courseData as $item) {
            \Redis::hset('course', $item['id'], json_encode($item));
        }
        dd('ok');
    }
    public function testStudentredis(){
        $studentData = Student::query()->get();
        foreach ($studentData as $item){
            \Redis::hset('student',$item['id'],json_encode($item));
        }
        dd('ok');
    }
    public function testSchoolredis(){
        $schoolData = School::query()->get();
        foreach ($schoolData as $item){
            \Redis::hset('school',$item['id'],json_encode($item));
        }
        dd('ok');
    }
    public function testTeacherredis(){
        $teacherData = Teacher::query()->get();
        foreach ($teacherData as $item){
            \Redis::hset('teacher',$item['id'],json_encode($item));
        }
        dd('ok');
    }
}
