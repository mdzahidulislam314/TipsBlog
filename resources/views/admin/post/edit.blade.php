@extends('layouts.backend.app')

@section('title','Post')

@push('css')
<!-- Bootstrap Select Css -->
<link href="{{asset('asset/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush

@section('content')

<div class="container-fluid">
    <form action="{{route('admin.post.update',$post->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIT POST
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group form-float">
                                    <p>
                                        <b>Post Title:</b>
                                    </p>
                                    <div class="form-line">
                                        <input type="text" id="title" class="form-control" name="title"
                                            value="{{$post->title}}">
                                        {{-- <label class="form-label">Post Title</label> --}}
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <p>
                                        <b>Feature Image:</b>
                                    </p>
                                    <div class="form-line">
                                        <input type="file" id="image" class="form-control" name="image">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" value="1" id="publish" class="filled-in" name="status"
                                        {{$post->status == true ? 'checked' : ''}}>
                                    <label for="publish">Publish</label>
                                </div>
                                <br>

                                <button type="submit" class="btn btn-success m-t-15 waves-effect">SUBMIT</button>
                                <a href="{{route('admin.post.index')}}" type="button" class="btn btn-danger m-t-15
                                waves-effect">
                                    BACK
                                </a>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group form-float">
                                    <div class="">
                                        <p>
                                            <b>Category Select:</b>
                                        </p>

                                        <select class="form-control show-tick" name="categories[]" multiple>
                                            @foreach ($categories as $category )
                                            <option value="{{$category->id}}"
                                                @foreach ($post->categories as $postCategory )
                                                    @if ($postCategory->id == $category->id)
                                                    selected
                                                    @endif
                                                @endforeach
                                                >{{$category->name}}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="">
                                        <p>
                                            <b>Tag Select:</b>
                                        </p>
                                        <select class="form-control show-tick" name="tags[]" multiple>
                                            @foreach ($tags as $tag)
                                            <option value="{{$tag->id}}"
                                            @foreach($post->tags as $postTag)
                                              @if($postTag->id == $tag->id)
                                                  selected
                                              @endif
                                            @endforeach
                                            >{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                    </div>
                    <div class="body">
                        <textarea id="tinymce" name="body">{{$post->body}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('js')
<!-- TinyMCE -->
<script src="{{asset('asset/backend/plugins/tinymce/tinymce.js')}}"></script>
{{-- //TinyMCE activation --}}
<script>
    $(function () {

        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{asset('asset/backend/plugins/tinymce')}}';
        });

</script>
@endpush
