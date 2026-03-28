<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $articles = Articles::where('category_id', $category->id)->latest()->paginate(15);
        return view('front.category', compact('category', 'articles'));
    }
}
