<x-app-layout>
    <x-slot name="header">
        <div x-data="{ addUser: false }" class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20h6M9 20H4v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                사용자 관리
            </h2>
            <button @click="addUser = true" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                사용자 추가
            </button>

            <!-- 사용자 추가 모달 -->
            <div x-show="addUser" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.away="addUser = false">
                <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white p-6 rounded shadow max-w-md w-full">
                    @csrf
                    <h2 class="text-lg font-bold mb-4">➕ 새 사용자 등록</h2>
                    <input name="name" type="text" class="border w-full px-3 py-2 rounded mb-3" placeholder="이름" required />
                    <input name="login_id" type="text" class="border w-full px-3 py-2 rounded mb-3" placeholder="아이디" required />
                    <input name="email" type="email" class="border w-full px-3 py-2 rounded mb-3" placeholder="이메일" required />
                    <input name="password" type="password" class="border w-full px-3 py-2 rounded mb-3" placeholder="비밀번호" required />
                    <select name="role" class="border w-full px-3 py-2 rounded mb-3" required>
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                    <label class="inline-flex items-center mb-3">
                        <input type="checkbox" disabled class="form-checkbox" />
                        <span class="ml-2">등록 후 메일 알림 전송 (준비중)</span>
                    </label>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="addUser = false" class="px-4 py-2 bg-gray-400 text-white rounded">취소</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">등록</button>
                    </div>
                </form>
            </div>
        </div>
        {{ session('success') }}
    </x-slot>
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-4 mb-4 max-w-screen-xl mx-auto px-4">

        <!-- 이름 또는 이메일 -->
        <input type="text" name="keyword"
                value="{{ request('keyword') }}"
                placeholder="이름 또는 이메일 검색"
                class="border px-4 py-2 rounded w-full sm:w-1/3">

        <!-- 권한 선택 -->
        <select name="role" class="border px-4 py-2 rounded w-full sm:w-1/5">
            <option value="">전체 권한</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
        </select>

        <!-- 버튼 그룹 -->
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            🔍 검색
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
            🔄 초기화
            </a>
        </div>
    </form>

    <!-- 사용자 목록 테이블 -->
    <div class="overflow-x-auto bg-white rounded shadow border mt-4">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
            <tr>
                <th class="px-4 py-2">이름</th>
                <th class="px-4 py-2">이메일</th>
                <th class="px-4 py-2">역할</th>
                <th class="px-4 py-2">가입일</th>
                <th class="px-4 py-2 text-center">동작</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @forelse ($users as $user)
                <tr>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->role }}</td>
                <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                <td class="px-4 py-2 text-center text-sm text-gray-500 space-x-2">
                    <span class="text-blue-500">상세</span>
                    <span class="text-yellow-500">수정</span>
                    <span class="text-red-500">삭제</span>
                    <span class="text-rose-500">🔔 알림</span>
                </td>
                </tr>
            @empty
                <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">사용자가 없습니다.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
