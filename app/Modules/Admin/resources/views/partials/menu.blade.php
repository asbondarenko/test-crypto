<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu tree" data-widget="tree" data-animation-speed="200">
    <li @if(Request::path() == 'dashboard') class="active" @endif>
        <a href="{{ url(config('admin.homeRoute')) }}">
            <i class="fa fa-dashboard"></i>
            <span>{{ trans('Admin::admin.Dashboard') }}</span>
        </a>
    </li>

    @foreach($menus as $menu)
        {{--@if ($menu->availableForRole(Auth::user()->role))--}}
            @if($menu->menu_type != 2 && is_null($menu->parent_id))
                <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($menu->plural_name)) class="active" @endif>
                    <a href="{{ route(config('admin.route').'.'.strtolower($menu->plural_name).'.index') }}">
                        <i class="fa {{ $menu->icon }}"></i>
                        <span class="title">{{ trans('Admin::admin.' . $menu->title) }}</span>
                    </a>
                </li>
            @else
                @if(!is_null($menu->children()->first()) && is_null($menu->parent_id))
                    <li>
                        <a href="#">
                            <i class="fa {{ $menu->icon }}"></i>
                            <span class="title">{{ $menu->title }}</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            @foreach($menu['children'] as $child)
                                <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($child->plural_name)) class="active active-sub" @endif>
                                    <a href="{{ route(strtolower(config('admin.route').'.'.$child->plural_name).'.index') }}">
                                        <i class="fa {{ $child->icon }}"></i>
                                        <span class="title">
                                            {{ $child->title  }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif
        {{--@endif--}}
    @endforeach

    @role(\App\Models\Role::ADMIN)
    <li @if(Request::path() == config('admin.route').'/menu') class="active" @endif>
        <a href="{{ url(config('admin.route').'/menu') }}">
            <i class="fa fa-list"></i>
            <span class="title">{{ trans('Admin::admin.partials-sidebar-menu') }}</span>
        </a>
    </li>
    <li class="@if(strpos(Request::path(), 'settings') !== false){{ 'active' }}@endif">
        <a href="{{ route(config('admin.route') . '.settings.index') }}">
            <i class="fa fa-gear"></i>
            {{ __('Settings') }}
        </a>
    </li>
    @endrole
</ul>
