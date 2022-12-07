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
            $category->fill($request->all());
            $category->slug=Str::slug($category->title);
            $category->save();
            return redirect()->route('admin.categories.index')->with('success', 'A category item was added successfully!');
        }

        return view('admin.categories.create', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.create', [            
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {

        $category->fill($request->all());
        $category->slug=Str::slug($category->title);
        $category->save();
        return redirect()->route('admin.categories.index')->with('success', 'The category was successfully updated!');
    }

    public function delete(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'The category was successfully deleted!');
    }
}
