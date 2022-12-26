<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{

    public function index()
    {
        $news = News::query()->paginate(20);

        return view('admin.news.index')->with('news', $news);
    }



    public function create()
    {
        $news = new News();
        return view('admin.news.create', [
            'news' => $news,
            'categories' =>  Category::all()
        ]);
    }


    public function store(Request $request)
    {
        $news = new News();
        return $this->saveData($request, $news);
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
        return $this->saveData($request, $news);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'The news item was successfully deleted!');
    }
    /**
     * Saves data for create and update
     *
     * @return void
     */
    private function saveData(Request $request, News $news)
    {
        $tableNameCategory = (new Category())->getTable();
        $tableNameNews = (new News())->getTable();

        $this->validate($request, [
            'title' =>
            [
                'required', 'min:3', 'max:200',
                Rule::unique($tableNameNews)->ignore($news->id),
            ],
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
}
