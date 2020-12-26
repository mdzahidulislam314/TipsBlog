<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required'
        ]);

        $image = $request->file('image');
        $slug   = Str::slug($request->name);
        // image processing
        $imageName = $slug . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        $directory = './category-image/';
        $image->move($directory, $imageName);
        $imageUrl = $directory . $imageName;

        $category = new Category();
        $category->name = $request->name;
        $category->slug =  $slug;
        $category->image = $imageUrl;
        $category->save();
        Toastr::success('Category Created Successfully', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);


        $category = Category::find($id);
        $image = $request->file('image');

        if ($image) {
            unlink($category->image);
            $slug   = Str::slug($request->name);
            $imageName = $slug . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = './category-image/';
            $image->move($directory, $imageName);
            $imageUrl = $directory . $imageName;
        } else {
            $imageUrl = $category->image;
        }

        $category->name = $request->name;
        $category->slug =  $slug;
        $category->image = $imageUrl;
        $category->save();
        Toastr::success('Category Updated Successfully', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        unlink($category->image);
        $category->delete();
        Toastr::success('Category Deleted Successfully', 'success');
        return redirect()->route('admin.category.index');
    }
}
