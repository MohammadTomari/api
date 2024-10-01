<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = array(
            array(
                'title' => 'Post 1',
                'text' => 'this a text',
                'user_id' => 1,
            ),
            array(
                'title' => 'Post 2',
                'text' => 'this a text',
                'user_id' => 1,
            )
        );

        foreach($posts as $post)
        {
            DB::table('posts')->insert([
                'title' => $post['title'],
                'text' => $post['text'],
                'user_id' => $post['user_id'],
                'created_at' => date('Y-m-d H:i'),
                'updated_at' => date('Y-m-d H:i'),
            ]);
        }
    }
}
