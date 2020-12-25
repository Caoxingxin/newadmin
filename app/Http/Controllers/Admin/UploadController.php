<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UploadController extends Controller
{
    public function upImage(Request $request){
        $image = $request->file('file');
        if ($image) {
            //获取文件的原文件名 包括扩展名
            $yuanname= $image->getClientOriginalName();

            //获取文件的扩展名
            $kuoname=$image->getClientOriginalExtension();

            //获取文件的类型
            $type=$image->getClientMimeType();

            //获取文件的绝对路径，但是获取到的在本地不能打开
            $path=$image->getRealPath();

            //要保存的文件名 时间+扩展名
            $filename=date('Y-m-d') . '/' . uniqid() .'.'.$kuoname;
            //保存文件          配置文件存放文件的名字  ，文件名，路径
            $bool= Storage::disk('uploadimg')->put($filename,file_get_contents($path));
            //return back();
            return json_encode(['status'=>1,'filepath'=>$filename]);

        } else {
            return response()->json([], 500, '文件未通过验证');
        }
    }
}
