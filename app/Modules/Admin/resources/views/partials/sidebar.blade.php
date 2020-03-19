@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    @if (!empty(Auth::user()->avatar->url))
                        <img src="{{ Auth::user()->avatar->url }}" class="img-circle" alt="User Image">
                    @else
                        <img src="{{ asset('images/no-avatar.png') }}" class="img-circle" alt="User Image">
                    @endif
                </div>
                <div class="pull-left info">
                    <p><a href="{{ route(config('admin.route') . '.users.profile') }}">{{ Auth::user()->name }}</a></p>
                    <a href="#"><i class="fa fa-circle text-success"></i>{{__('Admin::admin.partials-sidebar-Online')}}</a>
                </div>
            </div>

            @include('Admin::partials.menu')

        </section>
        <!-- /.sidebar -->
    </aside>
@endif
