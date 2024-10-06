<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users = [
           ['name'=>'Admin', 'email'=>'admin@gmail.com', 'password'=>bcrypt('admin123')],
           ['name'=>'Moderator', 'email'=>'moderator@gmail.com', 'password'=>bcrypt('admin123')],
           ['name'=>'Developer', 'email'=>'developer@gmail.com', 'password'=>bcrypt('admin123')]
       ];
       User::insert($users);
    }
}
