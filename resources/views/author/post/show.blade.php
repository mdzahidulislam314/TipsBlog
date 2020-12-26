@extends('layouts.backend.app')

@section('title','Post')

@push('css')
@endpush

@section('content')

    <div class="container-fluid">
        <div class="block-header">
                <a href="{{ route('author.post.index') }}" class="btn btn-danger waves-effect"><i
                        class="material-icons">chevron_left</i>BACK</a>
        </div>
        <div class="row clearfix">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{ $post->title }}
                                <small>Posted By <strong> <a href="">{{ $post->user->name }}</a></strong> on {{ $post->created_at->toFormattedDateString() }}</small>
                            </h2>
                        </div>
                        <div class="body">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="padding: 13px">
                            <h2>
                                Categories
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="label bg-cyan">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header bg-orange" style="padding: 13px">
                            <h2>
                                Tags
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="label bg-orange">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header bg-orange" style="padding: 13px">
                            <h2>
                                Featured Image
                            </h2>
                        </div>
                        <div class="body">
                            <img src="{{url($post->image)}}" class="img-responsive thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

@endpush
