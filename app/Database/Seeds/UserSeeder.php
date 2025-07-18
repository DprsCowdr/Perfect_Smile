<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create default users
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@perfectsmile.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'user_type' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'doctor',
                'email' => 'doctor@perfectsmile.com',
                'password' => password_hash('doctor123', PASSWORD_DEFAULT),
                'user_type' => 'doctor',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'staff',
                'email' => 'staff@perfectsmile.com',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'user_type' => 'staff',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Check if users already exist and insert only if they don't
        foreach ($users as $user) {
            $existingUser = $this->db->table('user')
                                    ->where('email', $user['email'])
                                    ->get()
                                    ->getRow();

            if (!$existingUser) {
                $this->db->table('user')->insert($user);
                echo "Created user: {$user['username']} ({$user['email']})\n";
            } else {
                echo "User already exists: {$user['username']} ({$user['email']})\n";
            }
        }

        echo "User seeding completed!\n";
    }
}
