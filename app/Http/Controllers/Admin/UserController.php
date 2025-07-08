<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, '관리자만 접근할 수 있습니다.');
        }

        return view('admin.users.index');
    }
}
