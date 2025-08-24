<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'     => 'Admin User',
                'email'    => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Instructor One',
                'email'    => 'instructor1@example.com',
                'password' => password_hash('teach123', PASSWORD_DEFAULT),
                'role'     => 'instructor',
            ],
            [
                'name'     => 'Student One',
                'email'    => 'student1@example.com',
                'password' => password_hash('stud123', PASSWORD_DEFAULT),
                'role'     => 'student',
            ],
            [
                'name'     => 'Student Two',
                'email'    => 'student2@example.com',
                'password' => password_hash('stud123', PASSWORD_DEFAULT),
                'role'     => 'student',
            ],
        ];

        // Insert multiple rows
        $this->db->table('users')->insertBatch($data);
    }
}
