@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">

            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ trans('common/labels.name') }}
                    </label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ trans('common/labels.email-address') }}
                    </label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ trans('common/labels.role') }}
                    </label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ trans('options.role.' . $user->role) }}</p>
                    </div>
                </div>
                @if ($user->isMember())
                <div class="form-group">
                    <div class="col-sm-10">
                        <a href="{{ action('Admin\UsersController@edit', ['id' => $user->id]) }}" class="btn btn-success">  
                            {{ trans('common/buttons.update') }}
                        </a>
                    </div>
                </div>
                @endif
            </form>

        </div>
    </div>
@endsection
