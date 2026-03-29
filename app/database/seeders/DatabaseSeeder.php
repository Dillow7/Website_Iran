<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $categoryNames = ['Politique', 'Militaire', 'Diplomatie', 'Économie'];

        $categories = collect($categoryNames)->map(function (string $name) {
            return Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name]
            );
        });

        $firstCategory = $categories->first();
        if ($firstCategory) {
            Article::firstOrCreate(
                ['slug' => 'tensions-croissantes-au-moyen-orient'],
                [
                    'title' => 'Tensions croissantes au Moyen-Orient',
                    'excerpt' => 'Analyse de la situation diplomatique actuelle en Iran.',
                    'content' => '<h2>Contexte</h2><p>Contenu complet de l\'article...</p>',
                    'meta_description' => 'Analyse des tensions diplomatiques en Iran en 2026.',
                    'alt_image' => 'Carte du Moyen-Orient montrant l\'Iran',
                    'category_id' => $firstCategory->id,
                    'user_id' => $admin->id,
                    'published_at' => now(),
                ]
            );
        }
    }
}
