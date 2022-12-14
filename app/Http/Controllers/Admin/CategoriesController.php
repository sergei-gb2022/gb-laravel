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
        $categories = Category::query()->paginate(20);

        return view('admin.categories.index')->with('categories', $categories);
    }



    public function create()
    {
        $category = new Category();
        return view('admin.categories.create', [
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $category = new Category();
        return $this->saveData($request, $category);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.create', [
            'category' => $category
        ]);
    }


    public function update(Request $request, Category $category)
    {

        return $this->saveData($request, $category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'The category was successfully deleted!');
    }

    /**
     * Saves data for create and update
     *
     * @return void
     */
    private function saveData(Request $request, Category $category){
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
}
