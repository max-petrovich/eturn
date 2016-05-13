<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('admin.users.index', [
            'pageTitle' => trans('admin.users'),
            'users' => $users
        ]);
    }
}
