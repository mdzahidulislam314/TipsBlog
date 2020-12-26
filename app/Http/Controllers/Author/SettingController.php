<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        return view('author.settings');
    }

    public function ProfileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $user   = User::findOrFail(Auth::id());

        if ($image) {
//            unlink($user->image);
            $slug   = Str::slug($request->name);
            $imageName = $slug . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = './profile-image/';
            $image->move($directory, $imageName);
            $imageUrl = $directory . $imageName;
        } else {
            $imageUrl = $user->image;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->image = $imageUrl;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Profile Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;

        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Your Password has been Updated!','');
                Auth::logout();
                return redirect()->back();
            }else
            {
                Toastr::error('New pass cannot be same old password','errors');
                return redirect()->back();
            }
        }else
        {
            Toastr::error('Old password cannot be match','');
            return redirect()->back();
        }

    }
}
