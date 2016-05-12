<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.orders');
        // TODO если что-то придумается - сделать вывод главной
//        return view('admin.index',[
//            'pageTitle' => trans('admin.admin_title')
//        ]);
    }
}
