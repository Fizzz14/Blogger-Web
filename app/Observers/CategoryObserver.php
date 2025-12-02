<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    public function creating(Category $category)
    {
        if (empty($category->slug)) {
            $category->slug = $this->generateUniqueSlug($category->name);
        }
    }

    public function updating(Category $category)
    {
        if ($category->isDirty('name') && empty($category->slug)) {
            $category->slug = $this->generateUniqueSlug($category->name);
        }
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Category::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
