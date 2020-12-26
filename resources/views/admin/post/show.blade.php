@extends('layouts.backend.app')

@section('title','Post')

@push('css')
@endpush

@section('content')

    <div class="container-fluid">
        <div class="block-header">
                <a href="{{ route('admin.post.pending') }}" class="btn btn-danger waves-effect"><i
                        class="material-icons">arrow_back</i></a>
                @if($post->is_approved == false)
                    <button type="button" class="btn btn-success waves-effect pull-right" onclick="approvePost({{ $post->id }})">
                        <i class="material-icons">navigate_next</i>
                        <span>Click to Approve</span>
                    </button>
                    <form method="post" action="{{ route('admin.post.approve',$post->id) }}" id="approval-form" style="display: none">
                        @csrf
                        @method('PUT')
                    </form>
                @else
                    <button type="button" class="btn btn-success pull-right" disabled>
                        <i class="material-icons">done</i>
                        <span>It's Approved</span>
                    </button>
                @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        function approvePost(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't Approved this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('approval-form').submit();
                }
            })
        }
    </script>
@endpush
