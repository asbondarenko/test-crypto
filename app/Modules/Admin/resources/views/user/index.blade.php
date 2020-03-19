@extends('Admin::layouts.master')

@section('page-header')

    @include('Admin::partials.page-header')

@endsection

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <a href="{{ route(config('admin.route').'.users.create') }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> {{ trans('Admin::admin.add-new', ['item' => trans('Admin::models.' . $menuRoute->singular_name)]) }}</span></a>
        </div>
        <div class="box-body">
            <table id="datatable" class="table table-bordered table-hover">
                <thead>
                <tr>
{{--                    <th class="no-sort" width="5%" style="text-align: center">--}}
{{--                        {!! Form::checkbox('delete_all',1,false,['class' => 'mass']) !!}--}}
{{--                    </th>--}}
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    {{--<th>{{ __('Role') }}</th>--}}
                    <th>{{ __('Active') }}</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($users as $user)
                    <tr>
{{--                        <td  style="text-align: center">--}}
{{--                            {!! Form::checkbox('del-'.$user->id,1,false,['class' => 'single','data-id'=> $user->id]) !!}--}}
{{--                        </td>--}}
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        {{--<td>{{ $user->role->display_name ?? null }}</td>--}}
                        <td class="user-status">{{ $user->active ? __('Yes') : __('No') }}</td>
                        <td>
                            <a href="{{ route(config('admin.route').'.users.edit', [$user->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {{ trans('Admin::admin.users-index-edit') }}</a>
                            @if($user->active)
                                <a href="{{ route(config('admin.route').'.users.toggleStatus', [$user->id]) }}"
                                   class="btn btn-xs btn-default status-button"><i
                                            class="fa fa-window-close"></i> {{ trans('Admin::admin.users-status-block') }}</a>
                            @else
                                <a href="{{ route(config('admin.route').'.users.toggleStatus', [$user->id]) }}"
                                   class="btn btn-xs btn-default status-button"><i
                                            class="fa fa-check-circle"></i> {{ trans('Admin::admin.users-status-un-block') }}
                                </a>
                            @endif
                            <a href="{{ route(config('admin.route').'.users.destroy', [$user->id]) }}"
                               class="btn btn-xs btn-default delete-button"><i
                                        class="fa fa-trash"></i> {{ trans('Admin::admin.users-index-delete') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('after_scripts')

    @include('Admin::partials.datatable-scripts')
    <script>
        $('.status-button').on('click', function (e) {
            e.preventDefault();
            var $this = $(this),
                url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'PATCH',
                success: function (result) {
                    // Shows an alert with the result
                    new PNotify({
                        text: '{{ trans('Admin::admin.controller-successfully_updated', ['item' => trans('Admin::models.User')]) }}',
                        type: 'success'
                    });
                    let status = result.status ?
                        '{{ __('Yes') }}' :
                        '{{ __('No') }}';
                    let btnStatus = result.status ?
                       '<i class="fa fa-window-close"></i> ' + '{{ trans('Admin::admin.users-status-block') }}' :
                        '<i class="fa fa-check-circle"></i> ' + '{{ trans('Admin::admin.users-status-un-block') }}';
                    // Deletes the row from the table
                    table
                        .row($this.parents('tr').children('td.user-status').text(status))
                        .row($this.html(btnStatus))
                        .draw();
                },
                error: function (result) {
                    // Logs the error result to console
                    console.log(result);
                    // Shows an error
                    new PNotify({
                        text: '{{ trans('Admin::templates.templates-view_index-item_approved_error') }}',
                        type: 'warning'
                    })
                }
            })
        });
    </script>

@endsection