@extends('Admin::layouts.master')

@section('page-header')

    @include('Admin::partials.page-header')

@endsection

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            @include('Admin::partials.errors')

            {!! Form::open(['route' => config('admin.route') . '.settings.indexStore']) !!}

            <div class="box">

                <div class="box-body tab-content">
                    <div class="form-group col-md-12">
                        {!! Form::label('terms_and_conditions', __('Terms and conditions')) !!}
                        {!! Form::textarea('settings[terms_and_conditions]', old('terms_and_conditions', setting('terms_and_conditions', null)), array('class'=>'form-control ckeditor', 'id' => 'terms_and_conditions')) !!}
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