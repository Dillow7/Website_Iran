<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::withCount('articles')->get();

        return view('home', compact('articles', 'categories'));
    }
}
