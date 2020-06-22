<?php

use App\Permissions;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        factory(User::class, 3)->create(); // 'password' => bcrypt(USERPASSWORDHERE),

        $user = factory(User::class)->create([
            'name' => 'User Test',
            'email' => 'u@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => str_random(10),
        ]);
        $user->addRole(Permissions::ROLE_CUSTOMER);
        $user->save();

        $user = factory(User::class)->create([
            'name' => 'Admin Test',
            'email' => 'a@example.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);
        $user->addRole(Permissions::ROLE_ADMIN);
        $user->save();

        $user = factory(User::class)->create([
            'name' => 'Super Admin Test',
            'email' => 'sa@example.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);
        $user->addRole(Permissions::ROLE_SUPER_ADMIN);
        $user->save();
    }
}
