<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Where to redirect users after verification.
     *
     * @var FilesystemManager
     */
    protected $cloud;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cloud = Storage::cloud();
    }

    public function store(Request $request)
    {
        $file = $request->file('image');
        $filename = $file->hashName();
        $url = $this->uploadToCloud($file, $filename);
        Image::create([
            'filename' => $filename,
            'url' => $url
        ]);
        return ['name' => $filename, 'url' => $url];
    }

    public function update(Request $request, $filename)
    {
        // dd($request->file('image'));
        $file = $request->file('image');
        $url = $this->uploadToCloud($file, $filename);
        $image = Image::whereFilename($filename);
        if (!$image) {
            Image::create([
                'filename' => $filename,
                'url' => $url
            ]);
        }
        return ['name' => $filename, 'url' => $url];
    }

    private function uploadToCloud(UploadedFile $file, $filename)
    {
        $path = 'images/' . $filename;
        $this->cloud->put($path, file_get_contents($file));
        $url = $this->cloud->url($path);
        return $url;        
    }

    public function showByFileName(Request $request, $filename)
    {
        return $this->cloud->response('images/' . $filename);
    }

    public function show(Request $request, Image $image)
    {
        return $this->cloud->response('images/' . $image->filename);
    }
}
