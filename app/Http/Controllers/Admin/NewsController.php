<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class NewsController extends Controller
{

    public function index()
    {
        $news = News::query()->paginate(5);

        return view('admin.news.index')->with('news', $news);
    }



    public function create(Request $request)
    {
        $news = new News();

        if ($request->isMethod('post')) {
            $news->fill($request->all());
            $news->slug=Str::slug($news->title);
            $news->save();
            return redirect()->route('admin.news.index')->with('success', 'A news item was added successfully!');
        }

        return view('admin.news.create', [
            'news' => $news,
            'categories' =>  Category::all()
        ]);
    }

    public function edit(News $news)
    {
        return view('admin.news.create', [
            'news' => $news,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, News $news)
    {

        $news->fill($request->all());
        $news->isPrivate = isset($request->isPrivate);
        $news->slug=Str::slug($news->title);
        $news->save();
        return redirect()->route('admin.news.index')->with('success', 'The news item was successfully updated!');
    }

    public function delete(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'The news item was successfully deleted!');
    }
}
