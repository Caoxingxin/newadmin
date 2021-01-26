<?php


namespace App\Http\Services\Head;


use App\Http\Models\School\Classes;

class SchoolClassServices
{
    public function create(){

    }

    public function update(){

    }

    public function detail($id){
        $classData = Classes::query()->find($id);
        return $classData;
    }

    public function delete(){

    }
}
