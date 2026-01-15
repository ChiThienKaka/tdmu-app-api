<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            // Faculty ID: 1 - Sư phạm
            [
                'faculty_id' => 1,
                'major_name' => 'Sư phạm ngữ văn',
                'major_code' => '7140217',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_id' => 1,
                'major_name' => 'Giáo dục tiểu học',
                'major_code' => '7140202',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_id' => 1,
                'major_name' => 'Giáo dục mầm non',
                'major_code' => '7140201',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Faculty ID: 2 - Kinh tế
            [
                'faculty_id' => 2,
                'major_name' => 'Thương mại điện tử',
                'major_code' => '7340122',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Kiểm toán',
                'major_code' => '7340302',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Marketing',
                'major_code' => '7340115',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Logistics và Quản lý chuỗi cung ứng',
                'major_code' => '7510605',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Quản lý công nghiệp',
                'major_code' => '7510601',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Quản trị kinh doanh',
                'major_code' => '7340101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Tài chính - Ngân hàng',
                'major_code' => '7340201',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 2,
                'major_name' => 'Kế toán',
                'major_code' => '7340301',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 3 - Ngoại ngữ
            [
                'faculty_id' => 3,
                'major_name' => 'Ngôn ngữ hàn quốc',
                'major_code' => '7220210',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 3,
                'major_name' => 'Ngôn ngữ trung quốc',
                'major_code' => '7220204',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 3,
                'major_name' => 'Ngôn ngữ anh',
                'major_code' => '7220201',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 4 - Công nghiệp văn hóa
            [
                'faculty_id' => 4,
                'major_name' => 'Truyền thông đa phương tiện',
                'major_code' => '7320104',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 4,
                'major_name' => 'Âm nhạc',
                'major_code' => '7210405',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 4,
                'major_name' => 'Du lịch',
                'major_code' => '7810101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 4,
                'major_name' => 'Thiết kế đồ họa',
                'major_code' => '7210403',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 5 - Tự nhiên thực phẩm
            [
                'faculty_id' => 5,
                'major_name' => 'Toán học',
                'major_code' => '7460101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 5,
                'major_name' => 'Công nghệ sinh học',
                'major_code' => '7420201',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 5,
                'major_name' => 'Công nghệ thực phẩm',
                'major_code' => '7540101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 5,
                'major_name' => 'Hóa học',
                'major_code' => '7440112',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 6 - Khoa học quản lý
            [
                'faculty_id' => 6,
                'major_name' => 'Tâm lý học',
                'major_code' => '7310401',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 6,
                'major_name' => 'Quản lý đất đai',
                'major_code' => '7850103',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 6,
                'major_name' => 'Luật',
                'major_code' => '7380101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 6,
                'major_name' => 'Giáo dục học',
                'major_code' => '7140101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 6,
                'major_name' => 'Quản lý nhà nước',
                'major_code' => '7310205',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 6,
                'major_name' => 'Quản lý tài nguyên và môi trường',
                'major_code' => '7850101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 6,
                'major_name' => 'Kỹ thuật môi trường',
                'major_code' => '7520320',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 7 - Kỹ thuật công nghệ
            [
                'faculty_id' => 7,
                'major_name' => 'Công nghệ thông tin',
                'major_code' => '7480201',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 7,
                'major_name' => 'Công nghệ kỹ thuật ô tô',
                'major_code' => '7510205',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 7,
                'major_name' => 'Kỹ thuật điều khiển và Tự động hóa',
                'major_code' => '7520216',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 7,
                'major_name' => 'Kỹ thuật cơ điện tử',
                'major_code' => '7520114',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 7,
                'major_name' => 'Kỹ thuật điện',
                'major_code' => '7520201',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 7,
                'major_name' => 'Kỹ thuật phần mềm',
                'major_code' => '7480103',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 8 - Kiến trúc - Xây dựng - Quy hoạch
            [
                'faculty_id' => 8,
                'major_name' => 'Công nghệ chế biến lâm sản',
                'major_code' => '7549001',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 8,
                'major_name' => 'Kiến trúc',
                'major_code' => '7580101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 8,
                'major_name' => 'Kỹ thuật xây dựng',
                'major_code' => '7580201',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Faculty ID: 9 - Khoa học xã hội và nhân văn
            [
                'faculty_id' => 9,
                'major_name' => 'Quan hệ quốc tế',
                'major_code' => '7310206',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'faculty_id' => 9,
                'major_name' => 'Công tác xã hội',
                'major_code' => '7760101',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
