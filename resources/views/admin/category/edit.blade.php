@extends('layouts.backend.app')

@section('title','Catagory')

@push('css')

@endpush

@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        UPDATE CATEGORY
                    </h2>
                </div>
                <div class="body">
                    <form action="{{route('admin.category.update',$category->id)}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="name" class="form-control" name="name"
                                    value="{{$category->name}}">
                                <label class="form-label">Category Name</label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="file" id="image" class="form-control" name="image">
                                <img src="{{asset($category->image)}}" alt="" height="100" width="100">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success m-t-15 waves-effect">SUBMIT</button>
                        <a href="{{route('admin.category.index')}}" type="button" class="btn btn-danger m-t-15
                            waves-effect">BACK</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

@endpush