<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, '관리자만 접근할 수 있습니다.');
        }
        $loans = Loan::with('user')->latest()->get();

        return view('admin.loans.index', compact('loans'));
    }
}
