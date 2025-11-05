<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $users = User::all();

        $samplePosts = [
            'Hari ini kami menemukan 50 telur penyu hijau di Pantai Cilacap! Semoga semua bisa menetas dengan selamat 🐢',
            'Kegiatan pelepasan tukik hari ini sangat menyenangkan. Terima kasih kepada semua relawan yang sudah membantu!',
            'Tahukah kamu? Penyu bisa hidup hingga 100 tahun lho! Mari kita jaga agar mereka tetap lestari.',
            'Foto-foto dari kegiatan monitoring sarang penyu kemarin. Sangat mengharukan melihat penyu bertelur 😊',
            'Bergabunglah dengan kami dalam program konservasi penyu. Setiap kontribusi sangat berarti!',
        ];

        foreach ($samplePosts as $content) {
            Post::create([
                'user_id' => $users->random()->id,
                'content' => $content,
            ]);
        }
    }
}