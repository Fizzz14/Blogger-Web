<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Hanya buat Admin User saja
        User::firstOrCreate(
            ['email' => 'admin@blogger.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

//         $categories = [
//             ['name' => 'Technology', 'color' => '#3b82f6', 'description' => 'Latest tech news and innovations'],
//             ['name' => 'Lifestyle', 'color' => '#10b981', 'description' => 'Life tips and daily inspirations'],
//             ['name' => 'Travel', 'color' => '#f59e0b', 'description' => 'Travel guides and adventures'],
//             ['name' => 'Food', 'color' => '#ef4444', 'description' => 'Recipes and culinary experiences'],
//             ['name' => 'Health', 'color' => '#8b5cf6', 'description' => 'Health tips and wellness advice'],
//             ['name' => 'Business', 'color' => '#6366f1', 'description' => 'Business insights and strategies'],
//         ];

//         foreach ($categories as $categoryData) {
//             Category::firstOrCreate(
//                 ['name' => $categoryData['name']],
//                 $categoryData
//             );
//         }

//         // Buat beberapa artikel sample sebagai admin
//         $admin = User::where('email', 'admin@blogger.com')->first();

//         $articles = [
//             [
//                 'title' => 'Welcome to Blogger Platform',
//                 'content' => 'Welcome to our new blogging platform! This is a powerful and elegant platform built with Laravel that allows you to create, manage, and publish your articles with ease.

// ## Features:
// - **Easy Article Management**: Create, edit, and publish articles effortlessly
// - **Category Organization**: Organize your content with categories
// - **User Management**: Admin can manage staff and users
// - **Modern Design**: Clean and responsive design
// - **File Uploads**: Support for images and featured content

// Start creating amazing content today!',
//                 'excerpt' => 'Welcome to our new blogging platform. Discover all the amazing features we offer for content creators.',
//                 'category_id' => 1,
//                 'status' => 'published',
//                 'published_at' => now(),
//             ],
//             [
//                 'title' => 'Getting Started with Content Creation',
//                 'content' => 'Creating great content is both an art and a science. Here are some tips to get you started:

// 1. **Know Your Audience**: Understand who you are writing for
// 2. **Create Valuable Content**: Provide solutions and insights
// 3. **Use Engaging Headlines**: Capture attention from the start
// 4. **Include Visuals**: Images and formatting improve readability
// 5. **Be Consistent**: Regular posting builds audience trust

// Remember, great content takes time and practice. Keep writing and improving!',
//                 'excerpt' => 'Learn the fundamentals of creating engaging and valuable content for your audience.',
//                 'category_id' => 2,
//                 'status' => 'published',
//                 'published_at' => now()->subDays(1),
//             ],
//             [
//                 'title' => 'Platform Features Overview',
//                 'content' => 'Our platform offers a comprehensive set of features for bloggers and content creators:

// ### For All Users:
// - Article creation and management
// - Category browsing
// - Comment system
// - User profiles

// ### For Staff & Admin:
// - Category management
// - User management (Admin only)
// - Content moderation
// - Analytics and insights

// Explore all the features and make the most of our platform!',
//                 'excerpt' => 'Discover all the powerful features available in our blogging platform.',
//                 'category_id' => 1,
//                 'status' => 'published',
//                 'published_at' => now()->subDays(2),
//             ],
//         ];

//         foreach ($articles as $articleData) {
//             $article = Article::firstOrCreate(
//                 ['title' => $articleData['title']],
//                 array_merge($articleData, [
//                     'user_id' => $admin->id,
//                     'slug' => Str::slug($articleData['title']) . '-' . uniqid(),
//                 ])
//             );

//             // Buat sample comments untuk artikel yang baru dibuat
//             if ($article->wasRecentlyCreated) {
//                 Comment::firstOrCreate(
//                     [
//                         'article_id' => $article->id,
//                         'user_id' => $admin->id,
//                         'content' => 'Great platform! Looking forward to creating more content here.',
//                     ],
//                     ['is_approved' => true]
//                 );
//             }
//         }

//         $this->command->info('Database seeded successfully!');
//         $this->command->info('=== LOGIN CREDENTIALS ===');
//         $this->command->info('Admin: admin@blogger.com / password');
//         $this->command->info('========================');
//         $this->command->info('Note: Staff users should be created by Admin through User Management');
//         $this->command->info('Regular users can register through the registration form');
     }
 }
