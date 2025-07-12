<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 사용자 목록 페이지
    public function index(Request $request)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, '관리자만 접근할 수 있습니다.');
        }

        $query = User::query();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderByDesc('created_at')->get();

        // 사용자 목록 데이터 조회 등 추가 가능
        return view('admin.users.index', compact('users'));
    }

    // 사용자 등록 처리
    public function store(Request $request)
{
    if (auth()->user()?->role !== 'admin') {
        abort(403, '관리자만 접근할 수 있습니다.');
    }

    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'login_id' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'login_id' => $validated['login_id'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
        
        \Log::info('User created: ' . $user->id);
        return redirect()->route('admin.users.index')->with('success', '사용자가 등록되었습니다.');
    } catch (\Exception $e) {
        \Log::error('User creation failed: ' . $e->getMessage());
        return back()->withErrors(['error' => '사용자 등록에 실패했습니다.'])->withInput();
    }
}
}
