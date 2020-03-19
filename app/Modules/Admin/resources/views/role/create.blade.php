@extends('Admin::layouts.master')

@section('page-header')

    @include('Admin::partials.page-header')

@endsection

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <a href="{{ route(config('admin.route').'.roles.index') }}"><i class="fa fa-angle-double-left"></i> {{__('Back to all')}} <span>{{ trans('Admin::admin.roles-edit-back-to-index') }}</span></a><br><br>

            @include('Admin::partials.errors')

            {!! Form::open(['route' => config('admin.route').'.roles.store']) !!}
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('Admin::admin.add-new', ['item' => trans('Admin::models.' . $menuRoute->singular_name)]) }}</h3>
                </div>

                <div class="box-body row">

                    <div class="form-group col-md-12">
                        {!! Form::label('name', trans('Admin::admin.roles-create-name')) !!}
                        {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=> trans('Admin::admin.roles-create-name_placeholder')]) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('display_name', trans('Admin::admin.roles-create-display-name')) !!}
                        {!! Form::text('display_name', old('display_name'), ['class'=>'form-control', 'placeholder'=> trans('Admin::admin.roles-create-display-name_placeholder')]) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('description', trans('Admin::admin.roles-create-description')) !!}
                        {!! Form::text('description', old('description'), ['class'=>'form-control', 'placeholder'=> trans('Admin::admin.roles-create-description_placeholder')]) !!}
                    </div>

                </div>

                <div class="box-footer">

                    @include('Admin::partials.save-buttons')

                </div>
            </div>

            {!! Form::close() !!}

        </div>

    </div>

@endsection


