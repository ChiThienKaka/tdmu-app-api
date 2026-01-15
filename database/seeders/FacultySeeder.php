<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            [
                'faculty_name' => 'Sư phạm',
                'faculty_code' => 'SP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Kinh tế',
                'faculty_code' => 'KT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Ngoại ngữ',
                'faculty_code' => 'NN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Công nghiệp văn hóa',
                'faculty_code' => 'CNVH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Tự nhiên thực phẩm',
                'faculty_code' => 'TNTP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Khoa học quản lý',
                'faculty_code' => 'KHQL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Kỹ thuật công nghệ',
                'faculty_code' => 'KTCN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Kiến trúc - Xây dựng - Quy hoạch',
                'faculty_code' => 'KTXD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Khoa học xã hội và nhân văn',
                'faculty_code' => 'KHXHNV',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }
}
