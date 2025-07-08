<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // 관리자 계정
        User::create([
            'name' => '관리자',
            'login_id' => 'admin',  // ✅ 추가됨
            'email' => 'admin@example.com',
            'password' => Hash::make('1234'),
            'role' => 'admin',
        ]);

        // 일반 사용자 5명
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "사용자{$i}",
                'login_id' => "user{$i}",  // ✅ 추가됨
                'email' => "user{$i}@example.com",
                'password' => Hash::make('1234'),
                'role' => 'user',
            ]);
        }
    }
}
