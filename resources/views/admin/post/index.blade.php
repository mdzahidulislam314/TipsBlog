@extends('layouts.backend.app')

@section('title','Posts')

@push('css')
<link href="{{asset('asset/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}"
    rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>
            <a href="{{route('admin.post.create')}}" class="btn btn-warning waves-effect">
                <i class="material-icons">add</i>
                <span>Add New Post</span>
            </a>
            <a href="{{route('admin.post.pending')}}" class="btn btn-info waves-effect" style="float: right">
                <span>All Pending Posts</span>
                <i class="material-icons">chevron_right</i>
            </a>
        </h2>
    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        All Post
                        <span class="badge bg-blue">{{$posts->count() }}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Sataus</th>
                                    <th>Is-Aproved</th>
                                    <th>Created-at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>{{ $loop->index+ 1}}</td>
                                    <td>{{ Str::limit($post->title,'20')}}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->view_count }}</td>
                                    <td>
                                        @if($post->status == true)
                                        <span class="badge bg-blue">Published</span>
                                        @else
                                        <span class="badge bg-orange">Unpublished</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->is_approved == true)
                                        <span class="badge bg-green">Approved</span>
                                        @else
                                        <span class="badge bg-red">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at }}</td>
                                    <td class="text-center">
                                        <a href="{{route('admin.post.edit',$post->id)}}" class="btn btn-sm btn-primary"
                                            title="Edit button">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <a href="{{route('admin.post.show',$post->id)}}" class="btn btn-sm btn-info"
                                            title="Edit button">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" type="button"
                                            onclick="deletecategory({{$post->id}})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <form id="delete-form-{{$post->id}}"
                                            action="{{route('admin.post.destroy',$post->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>
@endsection


@push('js')
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('asset/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('asset/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
<script src="{{asset('asset/backend/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    function deletecategory(id) {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('delete-form-'+id).submit();
        }
        })
    }
</script>

@endpush
