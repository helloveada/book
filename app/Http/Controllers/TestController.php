<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * 测试
     */
    public function test()
    {
        $name = 'zhang yun peng';
        $age = 18;
        return view('test.index',compact(['name','age']));
    }
}
