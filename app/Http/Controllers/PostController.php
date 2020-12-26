<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->approved()->published()->get();
        return view('all-posts',compact('posts'));
    }

    public function details($slug)
    {
        $post = Post::where('slug', $slug)->first();

        //view count by session
        $blogKey = 'blog_' . $post->id;
        if (!Session::has($blogKey))
        {
            $post->increment('view_count');
            Session::put($blogKey, 1);
        }

        $randomPosts = Post::approved()->published()->take(3)->inRandomOrder()->get();
        return view('post', compact('post', 'randomPosts'));
    }

    public function postByCategory($slug)
    {
         $categories = Category::where('slug',$slug)->first();
         $posts = $categories->posts()->approved()->published()->get();
         return view('category_post',compact('categories','posts'));
    }

    public function postByTag($slug)
    {
         $tags = Tag::where('slug',$slug)->first();
         $posts = $tags->posts()->approved()->published()->get();
         return view('tag_post',compact('tags','posts'));
    }


}
