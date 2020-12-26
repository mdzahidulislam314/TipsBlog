
@extends('layouts.backend.app')

@section('title','Settings')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Update user Profile
                    </h2>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="">
                            <a href="#profile_with_icon_title" data-toggle="tab" aria-expanded="false">
                                <i class="material-icons">face</i> UPDATE PROFILE
                            </a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#password_with_icon_title" data-toggle="tab" aria-expanded="false">
                                <i class="material-icons">security</i> PASSWORD
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                                <div class="row clearfix">
                                    <form action="{{route('author.update.profile')}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                    <div class="col-sm-6">
                                        <label for="name">Full Name:</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control"  name="name"
                                                       value="{{Auth::user()->name}}"
                                                       placeholder="Enter your name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="username">Username:</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="email_address" name="username"
                                                       value="{{Auth::user()->username}}"
                                                       placeholder="Enter your username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email_address">Email adresss:</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="email" name="email"
                                                       value="{{Auth::user()->email}}" id="email_address"
                                                       class="form-control"
                                                       placeholder="Enter your email address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="image">Profile Image:</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" name="image" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="about">About Us:</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                 <textarea name="about" id="about" class="form-control"
                                                           rows="6">{{Auth::user()
                                                ->about}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                </div>
                             </form>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="password_with_icon_title">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="body">
                                        <form method="POST" action="{{route('author.update.password')}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="password" id="old_password" name="old_password"
                                                           class="form-control">
                                                    <label class="form-label">Old Password</label>
                                                </div>
                                            </div>

                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="password" id="password" name="password"
                                                           class="form-control">
                                                    <label class="form-label">New Password</label>
                                                </div>
                                            </div>

                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="password" id="confirm_password"
                                                           name="password_confirmation"
                                                           class="form-control">
                                                    <label class="form-label">Conform Password</label>
                                                </div>
                                            </div>

                                            <br>
                                            <button type="submit" class="btn btn-primary m-t-15
                                            waves-effect">UPDATE</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')


@endpush
