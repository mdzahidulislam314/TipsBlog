<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
       $authors = User::authors()
          ->withCount('posts')
          ->withCount('favorite_posts')
          ->withCount('comments')
          ->get();

        return view('admin.author',compact('authors'));
    }

    public function destroy($id)
    {

        $author = User::findOrfail($id);
        unlink($author->image);
        $author->delete();
        return redirect()->back();

    }
}
