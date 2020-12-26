<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{url(Auth::user()->image)}}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()
            ->name}}</div>
            <div class="email">{{Auth::user()
            ->email}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{Auth::user()->role->id == 1 ? route('admin.setting') : route('author.setting') }}"><i
                                class="material-icons">person</i>Profile</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>Sign Out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Menu Items-->
    <div class="menu">
        <ul class="list">
            {{-- Admin menu here --}}
            <li class="header">MAIN NAVIGATION</li>
            @if(Request::is('admin*'))
            <li class="{{ Request::is('admin/dashboard') ? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/post*') ? 'active' : ''}}">
                <a href="{{route('admin.post.index')}}">
                    <i class="material-icons">library_books</i>
                    <span>Posts</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/tag*') ? 'active' : ''}}">
                <a href="{{route('admin.tag.index')}}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Tags</span>
                </a>
            </li>

            <li class="{{ Request::is('admin/category*') ? 'active' : ''}}">
                <a href="{{route('admin.category.index')}}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/authors') ? 'active' : ''}}">
                <a href="{{route('admin.author.index')}}">
                    <i class="material-icons">account_circle</i>
                    <span>Authors</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/subscriber') ? 'active' : ''}}">
                <a href="{{route('admin.subscriber.index')}}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Subscribers</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/favorite') ? 'active' : '' }}">
                <a href="{{ route('admin.favorite.index') }}">
                    <i class="material-icons">favorite</i>
                    <span>Favorite Posts</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/comments') ? 'active' : ''}}">
                <a href="{{route('admin.comment.index')}}">
                    <i class="material-icons">comment</i>
                    <span>Comments</span>
                </a>
            </li>

            <li class="header">System</li>

            <li class="{{ Request::is('admin/setting') ? 'active' : ''}}">
                <a href="{{route('admin.setting')}}">
                    <i class="material-icons">settings</i>
                    <span>settings</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                    <i class="material-icons">input</i>
                    <span>Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

            @endif

            {{-- Author menu here --}}
            @if(Request::is('author*'))
            <li class="{{ Request::is('author/dashboard') ? 'active' : ''}}">
                <a href="{{route('author.dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('author/post*') ? 'active' : ''}}">
                <a href="{{route('author.post.index')}}">
                    <i class="material-icons">library_books</i>
                    <span>Posts</span>
                </a>
            </li>
            <li class="{{ Request::is('author/commnets') ? 'active' : ''}}">
                <a href="{{route('author.comment.index')}}">
                    <i class="material-icons">comment</i>
                    <span>Comments</span>
                </a>
            </li>

            <li class="header">System</li>

            <li class="{{ Request::is('author/setting') ? 'active' : ''}}">
                <a href="{{route('author.setting')}}">
                    <i class="material-icons">settings</i>
                    <span>settings</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                    <i class="material-icons">input</i>
                    <span>Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            @endif

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>
