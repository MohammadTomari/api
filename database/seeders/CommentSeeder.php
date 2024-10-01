<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = array(
            array(
                'text' => 'I like your post',
                'user_id' => 1,
                'post_id' => 1,
            ),
            array(
                'text' => 'Good',
                'user_id' => 1,
                'post_id' => 1,
            ),
            array(
                'text' => 'It is amazing!',
                'user_id' => 1,
                'post_id' => 1,
            ),
        );
        
        foreach($comments as $comment)
        {
            DB::table('comments')->insert([
                'text' => $comment['text'],
                'user_id' => $comment['user_id'],
                'post_id' => $comment['post_id'],
                'created_at' => date('Y-m-d H:i'),
                'updated_at' => date('Y-m-d H:i'),
            ]);
        }
    }
}
