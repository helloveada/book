<?php
namespace App\Http\Controllers\View;
use App\Http\Controllers\Controller;



class MemberController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }


}
