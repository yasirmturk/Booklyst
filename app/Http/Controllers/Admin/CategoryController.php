<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Show the category dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $data = [
            'page_title' => 'Business Category',
            'page_description' => 'List of all the business categories',
            'categories' => $categories,
        ];
        return view('admin.settings.category')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            // 'is_service' => 'required',
            // 'is_product' => 'required',
        ]);
        $isService = $request->is_service == 'on';
        $isProduct = $request->is_product == 'on';

        Category::create([
            'name' => $request->name,
            'is_service' => $isService,
            'is_product' => $isProduct,
        ]);

        return redirect()->route('admin.settings.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.settings.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
