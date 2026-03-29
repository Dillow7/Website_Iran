<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $articles = Article::published()->with('category')->get();
        $categories = Category::all();

        return response()
            ->view('sitemap', compact('articles', 'categories'))
            ->header('Content-Type', 'application/xml');
    }
}
