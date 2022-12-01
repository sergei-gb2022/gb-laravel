<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategories;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::query()->paginate(5);
        
        return view('news.index')->with('news', $news);
    }
    public function show(string $slug)
    {
        $newsItem =News::query()->where('slug', '=', $slug)->first();
        return view('news.detail')->with('newsItem', $newsItem);
    }
}
