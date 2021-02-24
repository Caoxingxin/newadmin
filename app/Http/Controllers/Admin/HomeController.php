<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\Auth\Admin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        //dd('后台首页，当前管理员：' . auth('admin')->user()->name);
        return view('Head.Home')->with('name',auth('admin')->user()->name)->with('id',auth('admin')->user()->id);
    }

    public function getList(){
        $data = Admin::query()->get();
        return $data;
    }
}
