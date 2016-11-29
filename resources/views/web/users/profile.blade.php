@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{ trans('front-end/users.profile.update-profile') }}</h3></div>
                @include('layouts.includes.messages')

                <div class="panel-body">
                    {!! Form::open(['action' => ['Web\UsersController@update', $user->id], 'method' => 'put']) !!}

                        <div class="form-group">
                            {!! Form::label('email', trans('front-end/users.email')) !!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', trans('front-end/users.name')) !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('chatwork_id', trans('front-end/users.profile.chatwork-id')) !!}
                            {!! Form::text('chatwork_id', $user->chatwork_id, ['class' => 'form-control', 
                                'placeholder' => trans('front-end/users.leave-blank')]) 
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('chatwork_id_confirmation', trans('front-end/users.profile.chatwork-id-confirm')) !!}
                            {!! Form::text('chatwork_id_confirmation', $user->chatwork_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', trans('front-end/users.password.password')) !!}
                            {!! Form::password('password', ['class' => 'form-control', 
                                'placeholder' => trans('front-end/users.leave-blank')]) 
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', trans('front-end/users.password.confirm-password')) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('current_password', trans('front-end/users.password.current-password')) !!}
                            {!! Form::password('current_password', ['class' => 'form-control', 
                                'placeholder' => trans('front-end/users.need-current-password')]) 
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('common/buttons.update'), ['class' => 'btn btn-success']) !!}
                            {!! Form::reset(trans('common/buttons.reset'), ['class' => 'btn btn-default']) !!}
                            <a href="{{ action('Web\UsersController@destroy', ['id' => $user->id]) }}" class="btn btn-danger" 
                                id="delete-account">
                                <strong>{{ trans('common/buttons.delete-account') }}</strong>
                            </a>
                        </div>

                    {!! Form::close() !!}

                    {!! Form::open(['action' => ['Web\UsersController@destroy', $user->id], 'method' => 'DELETE', 
                        'id' => 'delete-account-form']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $deleteConfirm = '{{ trans('front-end/users.profile.delete-account-confirm') }}';
</script>
@endsection
