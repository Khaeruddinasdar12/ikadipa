<?php

use Illuminate\Database\Seeder;
use App\Admin;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Super admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt(12345678),
            'role' => 'sa', //superadmin
        ]);

        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(12345678),
            'role' => 'a', //admin
        ]);
    }
}
