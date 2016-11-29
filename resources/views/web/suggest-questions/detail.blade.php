@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{ trans('front-end/users.profile.update-profile') }}</h3></div>
                @include('layouts.includes.messages')
                <div class="panel-body">

                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                {{ trans('common/labels.content') }}
                            </label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $sgQuestions->content }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject_duration" class="col-sm-2 control-label">
                                {{ trans('common/labels.subject') }}
                            </label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $sgQuestions->subject->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject_quantity" class="col-sm-2 control-label">
                                {{ trans('common/labels.answer') }}
                            </label>
                            <div class="col-sm-10">
                                @foreach ($sgQuestions->systemAnswers as $systemAnswer)
                                    <p class="form-control-static">{{ $systemAnswer->content }}&nbsp;&nbsp;
                                    @if ($systemAnswer->is_correct == config('answer.correct.true'))
                                        <a class="btn btn-primary btn-sm disabled" aria-disabled="true">
                                            {{ trans('options.question-is-correct.' . $systemAnswer->is_correct) }}
                                        </a>
                                    @else
                                    <a class="btn btn-danger btn-sm disabled" aria-disabled="true">
                                        {{ trans('options.question-is-correct.' . $systemAnswer->is_correct) }}
                                    </a>
                                    @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject_created" class="col-sm-2 control-label">
                                {{ trans('common/labels.type') }}
                            </label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ trans('options.question-type.' . $sgQuestions->type) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject_updated" class="col-sm-2 control-label">
                                {{ trans('common/labels.status') }}
                            </label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ trans('options.question-status.' . $sgQuestions->status) }}</p>
                            </div>
                        </div>
                        @if ($sgQuestions->status == config('options.status.inactive'))
                            {!! Form::open([
                                'action' => ['Web\SuggestQuestionsController@destroy', $sgQuestions->id],
                                'method' =>  'DELETE'
                            ]) !!}
                            <div class="form-group">
                                <div class="col-sm-10">
                                    {!! link_to_action('Web\SuggestQuestionsController@edit', trans('common/buttons.edit'), 
                                        $sgQuestions->id, array('class'=>'btn btn-primary')) 
                                    !!}
                                    {!! Form::submit(trans('common/buttons.delete'), [
                                        'class' => 'btn btn-danger'
                                    ])!!}
                                </div>
                            </div>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
