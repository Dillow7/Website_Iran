<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function show(Category $category, Article $article)
    {
        abort_if($article->category_id !== $category->id, 404);
        abort_if(! $article->published_at, 404);

        $article->load(['category', 'user']);

        $related = Article::published()
            ->where('category_id', $category->id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('front.article', compact('category', 'article', 'related'));
    }
}
