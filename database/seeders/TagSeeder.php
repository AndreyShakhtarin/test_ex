<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Sale', 'color' => '#ef4444'],
            ['name' => 'New', 'color' => '#22c55e'],
            ['name' => 'Popular', 'color' => '#f59e0b'],
            ['name' => 'Featured', 'color' => '#6366f1'],
            ['name' => 'Limited', 'color' => '#ec4899'],
            ['name' => 'Eco', 'color' => '#10b981'],
            ['name' => 'Premium', 'color' => '#8b5cf6'],
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
                'color' => $tag['color'],
            ]);
        }
    }
}
