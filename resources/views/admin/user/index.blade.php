@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            @if (count($users))
            <table class="table table-bordered">
                <tr>
                    <td>{{ trans('common/labels.id') }}</td>
                    <td>{{ trans('common/labels.name') }}</td>
                    <td>{{ trans('common/labels.email-address') }}</td>
                    <td>{{ trans('common/labels.role') }}</td>
                    <td>{{ trans('common/labels.action') }}</td>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="{{ action('Admin\UsersController@show', ['id' => $user->id]) }}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ trans('options.role.' . $user->role) }}</td>
                    <td>
                    @if ($user->isMember())
                        <div class="btn-group btn-group-sm">
                            <a href="{{ action('Admin\UsersController@edit', ['id' => $user->id]) }}" class="btn btn-warning">
                                {{ trans('common/buttons.edit') }}
                            </a>
                            <a class="btn btn-danger">{{ trans('common/buttons.delete') }}</a>
                        </div>
                    @endif
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $users->links() !!}
            @else
            <div class="alert alert-warning" role="alert">
                {{ trans('common/messages.empty-list') }}
            </div>    
            @endif
        </div>
    </div>
@endsection
