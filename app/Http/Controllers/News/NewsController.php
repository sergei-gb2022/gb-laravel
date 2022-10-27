<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategories;
use App\Models\News;

class NewsController extends Controller
{
    public function listCategory($categorySlug)
    {
        $category = (new NewsCategories)->getBySlug($categorySlug);
        if ($category === null) {
            return view('notFound');
        }
        $news =  (new News())->listByCategorySlug($categorySlug);
        if ($news === null) {
            return view('notFound');
        }

        return view('news.categoryDetail')
            ->with('news', $news)->with('category', $category);
    }
    public function show(string $slug)
    {
        $newsItem = (new News())->getBySlug($slug);
        if ($newsItem === null) {
            return view('notFound');
        }

        return view('news.detail')->with('newsItem', $newsItem);
    }
}
