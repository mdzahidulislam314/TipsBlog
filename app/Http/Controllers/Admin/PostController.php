<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use App\Subscriber;
use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
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
        return view('admin.post.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
        $posts->is_approved = true;
        if (isset($request->status)) {
            $posts->status = true;
        } else {
            $posts->status = false;
        }
        $posts->save();
        $posts->categories()->attach($request->categories);
        $posts->tags()->attach($request->tags);

        Toastr::success('Post Created Successfully', 'Success');
        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.post.edit',compact('tags','categories','post'));
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

        if ($post->user_id === Auth::id()) {

            $post->user_id = Auth::id();

        }else {
            
        }
        
        $post->slug = $slug;
        $post->image = $imageUrl;
        $post->body = $request->body;
        $post->is_approved = true;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Created Successfully', 'success');
        return redirect()->route('admin.post.index');
    }


    public function pending()
    {
        $posts = Post::where('is_approved',false)->get();
        return view('admin.post.pending',compact('posts'));
    }

    public function approval($id)
    {
        $post = Post::find($id);
        if ($post->is_approved == false)
        {
            $post->is_approved = true;
            $post->save();
            Toastr::success('Post Successfully Approved :)','Success');
        } else
        {
            Toastr::info('This Post is already approved','Info');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        unlink($post->image);
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();

        Toastr::success('Post Deleted Successfully', 'success');
        return redirect()->route('admin.post.index');
    }
}
