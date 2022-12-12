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
            return $this->store($request, $news);
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

    public function store(Request $request, News $news)
    {
        $tableNameCategory = (new Category())->getTable();
        $this->validate($request, [
            'title' => 'required|min:3|max:20',
            'text' => 'required|min:3',
            'isPrivate' => 'sometimes|in:1',
            'category_id' => "required|exists:{$tableNameCategory},id"
        ], [], [
            'title' => 'Title',
            'text' => 'Text',
            'category_id' => "News category"
        ]);

        $successMessage = 'The news item was successfully updated!';
        if ($news->id == null) {
            $successMessage = 'A news item was added successfully!';
        }
        $news->fill($request->all());
        $news->isPrivate = isset($request->isPrivate);
        $news->slug = Str::slug($news->title);
        $news->save();
        return redirect()->route('admin.news.index')->with('success', $successMessage);
    }


    public function update(Request $request, News $news)
    {
        return $this->store($request, $news);
    }

    public function delete(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'The news item was successfully deleted!');
    }
}
