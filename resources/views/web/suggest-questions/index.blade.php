@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="pull-left">{{ trans('front-end/users.suggest-question.suggested') }}</h3>
                    <div class="pull-right">
                        <a href="{{ action('Web\SuggestQuestionsController@create') }}" class="btn btn-primary">
                            {{ trans('common/buttons.create-suggest') }}
                        </a>
                    </div>
                </div>
                @include('layouts.includes.messages')

                    <div class="panel-body">
                        @if (count($suggestQuestions))
                        <table class="table table-bordered">
                            <tr>
                                <td>{{ trans('front-end/users.suggest-question.id') }}</td>
                                <td>{{ trans('front-end/users.suggest-question.content') }}</td>
                                <td>{{ trans('front-end/users.suggest-question.subject') }}</td>
                                <td>{{ trans('front-end/users.suggest-question.type') }}</td>
                                <td>{{ trans('front-end/users.suggest-question.status') }}</td>
                                <td>{{ trans('common/labels.action') }}</td>
                            </tr>
                            @foreach ($suggestQuestions as $suggestQuestion)
                            <tr>
                                <td>{{ $suggestQuestion->id }}</td>
                                <td>
                                    <a href="{{ action('Web\SuggestQuestionsController@show', ['id' => $suggestQuestion->id]) }}">
                                        {{ $suggestQuestion->content }}
                                    </a>
                                </td>
                                <td>{{ $suggestQuestion->subject->name }}</td>
                                <td>{{ trans('options.question-type.' . $suggestQuestion->type) }}</td>
                                <td>{{ trans('options.question-status.' . $suggestQuestion->status) }}</td>
                                @if ($suggestQuestion->status == config('question.status.inactive'))
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ action('Web\SuggestQuestionsController@edit', ['id' => $suggestQuestion->id]) }}" 
                                            class="btn btn-warning">
                                            {{ trans('common/buttons.edit') }}
                                        </a>
                                        <a class="btn btn-danger">{{ trans('common/buttons.delete') }}</a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </table>
                        {!! $suggestQuestions->links() !!}
                        @else
                        <div class="alert alert-warning" role="alert">
                            {{ trans('common/messages.empty-list') }}
                        </div>    
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
