@extends('Admin::layouts.master')

@section('page-header')

    @include('Admin::partials.page-header')

@endsection

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            @include('Admin::partials.errors')

            {!! Form::open(['route' => [config('admin.route').'.users.updateProfile'], 'enctype' => 'multipart/form-data']) !!}
            <div class="box">

                <div class="box-header with-border">
                </div>

                <div class="box-body row tab-content">
                    <div class="tab-pane active" id="my-data">
                        @include('Admin::user.partials.fields')
                    </div>
                </div>

                <div class="box-footer">

                    <button type="submit" class="btn btn-success">
                        <span class="fa fa-save" role="presentation" aria-hidden="true"></span> <span>{{ __('Save') }}</span>
                    </button>

                </div>
            </div>
            {!! Form::close() !!}

        </div>

    </div>
@endsection

@section('after_scripts')

    @include('Admin::partials.form-scripts')
    @include('Admin::user.partials.scripts')

@endsection


