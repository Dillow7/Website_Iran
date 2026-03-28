<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Articles::with('category')->latest()->paginate(15);
        $categories = Category::withCount('articles')->get();
        return view('home', compact('articles', 'categories'));
    }
}
