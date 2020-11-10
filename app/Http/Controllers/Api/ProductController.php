<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use App\Traits\CloudUpload;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use CloudUpload;
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|file',
        ]);

        $file = $request->file('image');
        $filename = $file->hashName();
        $url = $this->uploadToCloud($file, $filename);
        $image = Image::create([
            'filename' => $filename,
            'url' => $url
        ]);
        $product->images()->save($image);
        return $product;
    }

    public function removeImage(Request $request, Product $product)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);
        $image = Image::firstWhere('filename', $request->filename);
        if ($image) {
            $product->images()->detach($image);
            $image->delete();
        }
        return $product;
    }
}
