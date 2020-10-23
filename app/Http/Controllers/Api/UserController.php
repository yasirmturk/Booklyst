<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use App\Traits\CloudUpload;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use CloudUpload;
    /**
     * Display the currency logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function current(Request $request)
    {
        return $request->user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = $request->user();
        $user->name = $request->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $url = $this->uploadToCloud($file, $filename);
            $image = Image::create([
                'filename' => $filename,
                'url' => $url
            ]);
            $user->images()->save($image);
        }

        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response('User deleted successfully');
    }
}
