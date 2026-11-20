<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samplePosts = [
            [
                'title' => 'Top 10 Hidden Gem Beaches to Explore in Bali',
                'description' => "Bali is renowned for its iconic coastlines, but away from the crowds lie pristine, untouched shores. From Nyang Nyang Beach's towering limestone cliffs to the turquoise waters of Thomas Beach, this guide covers secret sanctuaries for tranquility and sunset lovers.",
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
                'status' => 'Active',
            ],
            [
                'title' => 'Alpine Adventures: Hiking the Swiss Mountains',
                'description' => 'The Swiss Alps offer breathtaking landscapes, flower-filled meadows, and panoramic peaks. Discover the best scenic trails in Zermatt and Lauterbrunnen suitable for both beginner hikers and experienced trekkers.',
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'status' => 'Active',
            ],
            [
                'title' => 'Cultural Journey: Exploring Kyoto Traditional Temples',
                'description' => 'Kyoto is the heart of Japanese tradition. Explore centuries-old wooden shrines, bamboo groves in Arashiyama, and tranquil rock gardens in Ryoan-ji during autumn foliage season.',
                'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
                'status' => 'Active',
            ],
            [
                'title' => 'Mediterranean Getaway: Sailing Across Greek Islands',
                'description' => 'Crystal waters, whitewashed villas, and delicious fresh seafood. Here is how to plan an island-hopping vacation across Santorini, Mykonos, Naxos, and Milos.',
                'image' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=800&q=80',
                'status' => 'Active',
            ],
            [
                'title' => 'Winter Haven: Skiing and Cabin Living in Aspen',
                'description' => 'A comprehensive draft guide on the best winter lodges, ski passes, and après-ski spots in Aspen Colorado for the upcoming holiday season.',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=800&q=80',
                'status' => 'Inactive',
            ],
        ];

        foreach ($samplePosts as $post) {
            Post::create($post);
        }
    }
}
