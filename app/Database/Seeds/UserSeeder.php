<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $usersProvider = auth()->getProvider();

        $testUsers = [
            [
                'username' => 'admin_test',
                'email'    => 'admin@test.com',
                'password' => 'password123',
                'role'     => 'admin',
            ],
            [
                'username' => 'produksi_test',
                'email'    => 'produksi@test.com',
                'password' => 'password123',
                'role'     => 'produksi',
            ],
            [
                'username' => 'distribusi_test',
                'email'    => 'distribusi@test.com',
                'password' => 'password123',
                'role'     => 'distribusi',
            ],
            [
                'username' => 'pelanggan_test',
                'email'    => 'pelanggan@test.com',
                'password' => 'password123',
                'role'     => 'pelanggan',
            ],
        ];

        foreach ($testUsers as $userData) {
            // Check if user already exists
            $existing = $usersProvider->findByCredentials(['email' => $userData['email']]);
            if ($existing) {
                continue;
            }

            $user = new User([
                'username' => $userData['username'],
                'email'    => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Save the user
            $usersProvider->save($user);

            // Retrieve the saved user entity (with ID)
            $user = $usersProvider->findById($usersProvider->getInsertID());

            // Add the role group
            $user->addGroup($userData['role']);
        }
    }
}
