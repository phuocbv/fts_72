@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            
            {!! Form::open(['action' => ['Admin\UsersController@store', 'method' => 'POST'],'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('common/labels.name'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('common/placeholders.name')]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('common/labels.email-address'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('common/placeholders.email')]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('role', trans('common/labels.role'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('role', getOptions('options.role'), null, ['placeholder' => trans('common/placeholders.options'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {!! Form::submit(trans('common/buttons.create'), ['class' => 'btn btn-success']) !!}
                        {!! Form::reset(trans('common/buttons.reset'), ['class' => 'btn btn-default']) !!}
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
