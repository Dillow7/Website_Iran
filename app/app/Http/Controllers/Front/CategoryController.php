<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(10);

        return view('front.category', compact('category', 'articles'));
    }
}
