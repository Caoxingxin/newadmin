<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/test', function () {
//    return view('test');
//});

//Auth::routes();

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' ,],function (){
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@login');

    Route::get('register', 'RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('register', 'RegisterController@register');

    Route::post('logout', 'LoginController@logout')->name('admin.logout');
    Route::post('upload','UploadController@upImage')->name('admin.upload');

    Route::group(['name'=>'admin.','middleware'=> ['auth.admin:admin'] ],function (){
        Route::get('/','HomeController@index');
    });

    Route::get('/get-admin-list','HomeController@getList')->name('get-list');

});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Head' , 'prefix' => 'head' ,],function (){
    //学校操作
    Route::get('/headSchool-list','HeadSchoolController@school_list')->name('headSchool-list');
    Route::post('/headSchool-status','HeadSchoolController@school_status')->name('headSchool-status');
    Route::post('/headSchool-create','HeadSchoolController@create')->name('headSchool-create');
    Route::post('/headSchool-detail','HeadSchoolController@detail')->name('headSchool-detail');
    Route::post('/headSchool-update','HeadSchoolController@update')->name('headSchool-update');

    //课程
    Route::get('/headCourse-list','HeadCourseController@list')->name('list');
    Route::post('/headCourse-detail','HeadCourseController@detail')->name('detail');
    Route::post('/headCourse-create','HeadCourseController@create')->name('create');
    Route::post('/headCourse-update','HeadCourseController@update')->name('update');
    Route::post('/headCourse-status','HeadCourseController@status')->name('status');
    Route::post('headCourse-delete','HeadCourseController@delete')->name('delete');

    //学生
    Route::get('/headStudent-list','HeadStudentController@list')->name('list');
    Route::post('/headStudent-detail','HeadStudentController@detail')->name('detail');
    Route::post('/headStudent-update','HeadStudentController@update')->name('update');

    //教师
    Route::get('/headTeacher-list','HeadTeacherController@list')->name('list');
    Route::post('/headTeacher-detail','HeadTeacherController@detail')->name('detail');
    Route::post('/headTeacher-update','HeadTeacherController@update')->name('update');
    Route::post('/headTeacher-create','HeadTeacherController@create')->name('create');
    Route::post('/headTeacher-delete','HeadTeacherController@delete')->name('delete');
    Route::post('/headTeacher-status','HeadTeacherController@status')->name('status');
});

Route::group(['namespace' => 'School' , 'prefix' => 'school' ,],function (){
    //学期操作
    Route::get('/schoolSemester-list','SchoolSemesterController@list')->name('list');
    Route::post('/schoolSemester-status','SchoolSemesterController@status')->name('status');
    Route::post('/schoolSemester-create','SchoolSemesterController@create')->name('create');
    Route::post('/schoolSemester-detail','SchoolSemesterController@detail')->name('detail');
    Route::post('/schoolSemester-update','SchoolSemesterController@update')->name('update');
    Route::post('/schoolSemester-delete','SchoolSemesterController@delete')->name('delete');

    //学生
    Route::get('/schoolStudent-list','SchoolStudentController@list')->name('list');
    Route::post('/schoolStudent-detail','SchoolStudentController@detail')->name('detail');
    Route::post('/schoolStudent-update','SchoolStudentController@update')->name('update');
    Route::post('/schoolStudent-create','SchoolStudentController@create')->name('create');

    Route::post('/get-student-list','SchoolStudentController@getList')->name('get-list');

    //教室
    Route::get('/schoolClassroom-list','SchoolClassroomController@list')->name('list');
    Route::post('/schoolClassroom-status','SchoolClassroomController@status')->name('status');
    Route::post('/schoolClassroom-create','SchoolClassroomController@create')->name('create');
    Route::post('/schoolClassroom-detail','SchoolClassroomController@detail')->name('detail');
    Route::post('/schoolClassroom-update','SchoolClassroomController@update')->name('update');
    Route::post('/schoolClassroom-delete','SchoolClassroomController@delete')->name('delete');

    //班级
    Route::get('/schoolClass-list','SchoolClassController@list')->name('list');
    Route::post('/schoolClass-status','SchoolClassController@status')->name('status');
    Route::post('/schoolClass-create','SchoolClassController@create')->name('create');
    Route::post('/schoolClass-detail','SchoolClassController@detail')->name('detail');
    Route::post('/schoolClass-update','SchoolClassController@update')->name('update');
    Route::post('/schoolClass-delete','SchoolClassController@delete')->name('delete');

    Route::post('/get-semester-list','SchoolSemesterController@getList')->name('get-list');

    //班级分班
    Route::get('/schoolClassAllot-list','StudentDistributeController@list')->name('list');
    Route::post('/schoolClassAllot-distribute','StudentDistributeController@distribute')->name('distribute');
    Route::post('/schoolClassAllot-remove','StudentDistributeController@remove')->name('remove');
    Route::get('/schoolClassAllot-showList','StudentDistributeController@showList')->name('showList');

    //学员报名
    Route::get('/schoolStudentRegister-list','StudentRegisterController@list')->name('list');
    Route::post('/schoolStudentRegister-create','StudentRegisterController@create')->name('create');
    Route::post('/schoolStudentRegister-detail','StudentRegisterController@detail')->name('detail');
    Route::post('/schoolStudentRegister-report','StudentRegisterController@report')->name('report');
    Route::post('/schoolStudentRegister-postpone','StudentRegisterController@postpone')->name('postpone');
    Route::post('/schoolStudentRegister-cancelRegister','StudentRegisterController@cancelRegister')->name('cancelRegister');

    //订单管理
    Route::get('/schoolOrder-list','OrderController@list')->name('list');
    Route::post('/schoolOrder-create','OrderController@create')->name('create');
    Route::post('/schoolOrder-detail','OrderController@detail')->name('detail');

    //付款记录
    Route::get('/schoolPaymentOrder-list','PaymentOrderController@list')->name('list');

});
