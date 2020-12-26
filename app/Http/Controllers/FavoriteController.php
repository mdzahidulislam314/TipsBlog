<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function add($post)
    {
        $user = Auth::user();
        $favorite = $user->favorite_posts()->where('post_id', $post)->count();

        if ($favorite == 0) {

            $user->favorite_posts()->attach($post);
            // Toastr::success('Post successfully added to your favorite list!', 'success');

            return redirect()->back();
        } else {

            $user->favorite_posts()->detach($post);
            // Toastr::success('Post successfully removed form your favorite list :)', 'Success');
            return redirect()->back();
        }
    }
}
