<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::query()->paginate(5);

        return view('admin.categories.index')->with('categories', $categories);
    }



    public function create(Request $request)
    {
        $category = new Category();

        if ($request->isMethod('post')) {
            return $this->store($request, $category);
        }

        return view('admin.categories.create', [
            'category' => $category,
        ]);
    }
    public function store(Request $request, Category $category)
    {
        //TODO: check unique slug
        $tableNameCategory = (new Category())->getTable();
        $this->validate($request, [
            'title' => 'required|min:3|max:20|unique:'.$tableNameCategory.',title',
        ], [], [
            'title' => 'Title',
            'text' => 'Text',
            'category_id' => "News category"
        ]);

        $successMessage = 'The category was successfully updated!';
        if ($category->id == null) {
            $successMessage = 'A category was added successfully!';
        }

        $category->fill($request->all());
        $category->slug = Str::slug($category->title);
        $category->save();
        return redirect()->route('admin.categories.index')->with('success', $successMessage);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.create', [
            'category' => $category
        ]);
    }


    public function update(Request $request, Category $category)
    {

        return $this->store($request, $category);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'The category was successfully deleted!');
    }
}
