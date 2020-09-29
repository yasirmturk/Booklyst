<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Traits\CloudUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use CloudUpload;
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
            'image' => 'required|image|max:1024',
            // 'is_service' => 'required',
            // 'is_product' => 'required',
        ]);
        $isService = $request->is_service == 'on';
        $isProduct = $request->is_product == 'on';

        $category = Category::create([
            'name' => $request->name,
            'is_service' => $isService,
            'is_product' => $isProduct,
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $url = $this->uploadToCloud($file, $filename);

            $image = Image::create([
                'filename' => $filename,
                'url' => $url
            ]);
            $category->images()->save($image);
        } else {
            Log::debug('no image found');
        }

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
