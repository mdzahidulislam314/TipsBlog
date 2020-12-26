<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscriber',compact('subscribers'));
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);
        $subscriber->delete();
        Toastr::success('Successfully Sub Deleted Done!','Success');
        return redirect()->route('admin.subscriber.index');
    }
}
