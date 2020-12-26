<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Http\Controllers\Controller;
use App\Notifications\NewAuthorPost;
use App\Post;
use App\Tag;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::User()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('author.post.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'image' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug  =  Str::slug($request->title);
        // image processing
        $imageName = $slug . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        $directory = './post-image/';
        $image->move($directory, $imageName);
        $imageUrl = $directory . $imageName;

        $posts = new Post;
        $posts->title = $request->title;
        $posts->user_id = Auth::user()->id;
        $posts->slug = $slug;
        $posts->image = $imageUrl;
        $posts->body = $request->body;

        if (isset($request->status)) {
            $posts->status = true;
        } else {
            $posts->status = false;
        }
        $posts->is_approved = false;
        $posts->save();
        $posts->categories()->attach($request->categories);
        $posts->tags()->attach($request->tags);
        
        Toastr::success('Post Created Successfully', 'success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //        check for authorize access
        if ($post->user_id != Auth::id())
        {
            Toastr::error('Your not access this post!', 'Error');
            return redirect()->back();
        }
        return view('author.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // check for authorize access
        if ($post->user_id != Auth::id())
        {
            Toastr::error('Your not access this post!', 'Error');
            return redirect()->back();
        }

        $tags = Tag::all();
        $categories = Category::all();
        return view('author.post.edit',compact('tags','categories','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug  =  Str::slug($request->title);

        if (isset($image))
        {
            // image processing
            unlink($post->image);
            $imageName = $slug . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = './post-image/';
            $image->move($directory, $imageName);
            $imageUrl = $directory . $imageName;
        }else{
            $imageUrl = $post->image;
        }

        $post->title = $request->title;
        $post->user_id = Auth::user()->id;
        $post->slug = $slug;
        $post->image = $imageUrl;
        $post->body = $request->body;
        $post->is_approved = false;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Created Successfully', 'success');
        return redirect()->route('author.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
//        check for authorize access
        if ($post->user_id != Auth::id())
        {
            Toastr::error('Your not access this post!', 'Error');
            return redirect()->back();
        }

        unlink($post->image);
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();

        Toastr::success('Post Deleted Successfully', 'Success');
        return redirect()->route('author.post.index');
    }
}
