<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSedder extends Seeder
{
    public function run(): void
    {
        // إنشاء مشرف المدرسة
        User::firstOrCreate(
            ['email' => 'supervisor@school.com'],
            [
                'name' => 'مشرف المدرسة',
                'password' => Hash::make('12345678'),
                'role' => 'supervisor',
            ]
        );

        // إنشاء موظف شؤون الطلبة
        User::firstOrCreate(
            ['email' => 'registrar@school.com'],
            [
                'name' => 'شؤون الطلبة',
                'password' => Hash::make('12345678'),
                'role' => 'registrar',
            ]
        );
    }
}