<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
           [ 'content'=> 'content 2','user_id'=> 2]
        ];
        \App\Models\Post::insert($posts);
    }
}
