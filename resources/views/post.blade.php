@extends('layouts.frontend.app')

@section('title','Homepage')

@push('css')
<link href="{{asset('asset/frontend/css/singel-post/styles.css')}}" rel="stylesheet">
<link href="{{asset('asset/frontend/css/singel-post/responsive.css')}}" rel="stylesheet">
<style>
    .header-bg {
        height: 400px;
        overflow: overlay;
    }

    #favorite_posts {
        color: blue;
    }
</style>
@endpush

@section('content')

<div class="header-bg">
    <img src="{{url($post->image)}}" alt="Post image">
</div>

<section class="post-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-1 col-md-0"></div>
            <div class="col-lg-10 col-md-12">
                <div class="main-post">
                    <div class="post-top-area">
                        <ul class="category">
                            @foreach ($post->categories as $category)
                                <li><a href="{{route('category.posts',$category->slug)}}">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                        <h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>
                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="#"><img src="{{url($post->user->image)}}"
                                        alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="#"><b>{{$post->user->name}}</b></a>
                                <h6 class="date">on {{$post->created_at->diffForHumans()}}</h6>
                            </div>

                        </div>

                        <div class="para">
                            {!! $post->body !!}
                        </div>

                        <ul class="tags">
                            @foreach ($post->tags as $tag)
                            <li><a href="{{route('tag.posts',$tag->slug)}}">{{$tag->name}}</a></li>
                            @endforeach
                        </ul>

                        <div class="post-icons-area">
                            <ul class="post-icons">
                                <li>
                                    @guest
                                        <a href="javascript:void(0);" onclick="toastr.info('To add favorite list,You need to login first :)','Info',{
                                            closeButton:true,
                                            progressBar:true,
                                        })"><i class="ion-heart"></i>
                                    </a>
                                    @else
                                    <a href="javascript:void(0);"
                                        onclick="document.getElementById('favorite-form-{{$post->id}}').submit();"><i
                                            class="ion-heart"
                                            id="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}"></i>{{$post->favorite_to_users->count()}}

                                    </a>
                                    <form action="{{route('favorite.post',$post->id)}}" method="POST"
                                        id="favorite-form-{{$post->id}}" style="display: none">
                                        @csrf
                                    </form>
                                    @endguest


                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments()->count()}}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>SHARE : </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>

                        <div class="post-footer post-info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="recomended-area section">
    <div class="container">
        <div class="row">
            @foreach ($randomPosts as $randomPost)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="single-post post-style-1">

                        <div class="blog-image"><img src="{{url($randomPost->image)}}" alt="Blog Image"></div>

                        <a class="avatar" href="#"><img src="{{url($randomPost->user->image)}}" alt="Profile Image"></a>

                        <div class="blog-info">

                            <h4 class="title">
                                <a href="{{route('post.details',$randomPost->slug)}}">
                                    <b>{{$randomPost->title}}</b>
                                </a>
                            </h4>

                            <ul class="post-footer">
                                <li>
                                    @guest
                                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite list,You need to login first','Info',{
                                        closeButton:true,
                                        progressBar:true,

                                    })"><i class="ion-heart"></i></a>
                                    @else
                                    <a href="javascript:void(0);"
                                        onclick="document.getElementById('favorite-form-{{$randomPost->id}}').submit();"><i
                                            class="ion-heart"
                                            id="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$randomPost->id)->count()  == 0 ? 'favorite_posts' : ''}}"></i>{{$randomPost->favorite_to_users->count()}}

                                    </a>
                                    <form action="{{route('favorite.post',$randomPost->id)}}" method="POST"
                                        id="favorite-form-{{$randomPost->id}}" style="display: none">
                                        @csrf
                                    </form>
                                    @endguest


                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>{{$randomPost->comments()->count()}}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{$randomPost->view_count}}</a></li>
                            </ul>

                        </div><!-- blog-info -->
                    </div><!-- single-post -->
                </div><!-- card -->
            </div>
            @endforeach
        </div><!-- row -->

    </div><!-- container -->
</section>
<section class="comment-section center-text">
    <div class="container">
        <h4><b>POST COMMENT</b></h4>
        <div class="row">

            <div class="col-lg-2 col-md-0"></div>

            <div class="col-lg-8 col-md-12">
                <div class="comment-form">
                    @guest
                    <p>For post a new comment. You need to login first. <a href="{{ route('login') }}">Login</a></p>
                    @else
                    <form method="post" action="{{route('comment.store',$post->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="comment" rows="3" class="text-area-messge form-control" placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea>
                            </div><!-- col-sm-12 -->
                            <div class="col-sm-12">
                                <button class="submit-btn" type="submit" id="form-submit"><b>POST
                                        COMMENT</b>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endguest

                </div>

                <h4><b>COMMENTS({{$post->comments()->count()}})</b></h4>

                @if ($post->comments->count() > 0)
                <div class="commnets-area text-left">
                    @foreach ($post->comments as $comment)
                    <div class="comment">
                        <div class="post-info">
                            <div class="left-area">
                                <a class="avatar" href="#"><img src="{{url($comment->user->image)}}" alt="Profile Image"></a>
                            </div>
                            <div class="middle-area">
                                <a class="name" href="#"><b>{{$comment->user->name}}</b></a>
                                <h6 class="date">on {{$comment->created_at->diffForHumans() }}</h6>
                            </div>
                            <div class="right-area">
                                <h5 class="reply-btn"><a href="#"><b>REPLY</b></a></h5>
                            </div>
                        </div>

                        <p>{{$comment->comment}}</p>

                    </div>
                    @endforeach
                </div>
                @else
                <div class="commnets-area text-left">
                    <div class="comment">
                        <p>No Comment This Post</p>
                    </div>
                </div>

                @endif
              

              
                </b></div><!-- col-lg-8 col-md-12 --><b>

            </b></div><!-- row --><b>

        </b></div><!-- container --><b>
    </b></section>

    @endsection


    @push('js')

    @endpush
