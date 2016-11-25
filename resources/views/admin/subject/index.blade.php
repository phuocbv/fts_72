@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            @if (count($subjects))
            <table class="table table-bordered">
                <tr>
                    <td>{{ trans('common/labels.id') }}</td>
                    <td>{{ trans('common/labels.name') }}</td>
                    <td>{{ trans('admin/subject.duration') }}</td>
                    <td>{{ trans('admin/subject.quantity') }}</td>
                    <td>{{ trans('common/labels.action') }}</td>
                </tr>
                @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->id }}</td>
                    <td>
                        <a href="{{ action('Admin\SubjectsController@show', ['id' => $subject->id]) }}">
                            {{ $subject->name }}
                        </a>
                    </td>
                    <td>{{ gmdate(config('subject.time-format'), $subject->duration) }}</td>
                    <td>{{ $subject->number_of_question }}</td>
                    <td>
                        {!! Form::open([
                            'action' => ['Admin\SubjectsController@destroy', $subject->id],
                            'method' =>  'DELETE'
                        ]) !!}
                            <div class="btn-group btn-group-sm">
                                {!! link_to_action('Admin\SubjectsController@edit', trans('common/buttons.edit'), [ 
                                    'id' => $subject->id 
                                ], [
                                    'class' => 'btn btn-default'
                                ]) !!}

                                {!! Form::submit(trans('common/buttons.delete'), [
                                    'class' => 'btn btn-danger'
                                ])!!}  
                            </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $subjects->links() !!}
            @else
            <div class="alert alert-warning" role="alert">
                {{ trans('common/messages.empty-list') }}
            </div>    
            @endif
        </div>
    </div>
@endsection
