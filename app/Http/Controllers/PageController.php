<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function catergories()
    {
        return view('admin.catergories-manager');
    }
    public function products(){
        return view('admin.products-manager');
    }
    public function slides()
    {
        return view('admin.slides-manager');
    }
    public function orders()
    {
        return view('admin.orders-manager');
    }
    public function users()
    {
        return view('admin.users-manager');
    }
    public function admins()
    {
        return view ('admin.admins-manager');
    }
}
