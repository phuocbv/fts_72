@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            
            {!! Form::open(['action' => ['Admin\QuestionsController@store'], 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('subject', trans('common/labels.subject'), [
                        'class' => 'col-sm-2 control-label'
                    ]) !!}
                    <div class="col-sm-10">
                        {!! Form::select('subject', $subjectsList, old('subject'), [
                            'placeholder' => trans('common/placeholders.options'),
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label(
                        'content', trans('common/labels.content'), ['class' => 'col-sm-2 control-label']
                    ) !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('content', old('content'), [
                            'class' => 'form-control',
                            'placeholder' => trans('common/placeholders.content')
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('type', trans('common/labels.type'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('type', getOptions('options.question-type'), old('type') ? 'checked' : '', [
                            'placeholder' => trans('common/placeholders.options'),
                            'class' => 'form-control',
                            'id' =>  'question-type'
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                {!! Form::hidden('active', config('answer.active.false')) !!}
                                {!! Form::checkbox('active', config('answer.active.true'), old('active')) !!}
                                {{ trans('common/placeholders.active') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Answers section -->
                <div id="answer-section">

                @if (old('answer'))
                    @foreach (old('answer') as $key => $answer)
                        <div class="form-group">
                            {!! Form::label('answer', trans('common/labels.answer'), [
                                'class' => 'col-sm-2 control-label'
                            ]) !!}
                            <div class="col-sm-6">
                                {!! Form::text('answer[' . $key . '][content]', old('answer[' . $key . '][content]'), [
                                    'class' => 'form-control',
                                    'placeholder' => trans('common/placeholders.content')
                                ]) !!}
                            </div>

                            <div class="checkbox-remove">
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" value="{{ config('answer.correct.false') }}" name="{{ 'answer[' . $key . '][is_correct]' }}">
                                            {!! Form::checkbox(
                                                'answer[' . $key . '][is_correct]',
                                                config('answer.correct.true'),
                                                $answer['is_correct'] ? 'checked' : '',
                                                ['class' => 'is_correct']
                                            ) !!}
                                            {{ trans('common/placeholders.is-correct') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="remove-answer btn btn-default" onclick="javascript:;">
                                        {{ trans('common/buttons.remove-answer') }}
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                @else
                    <div class="form-group">
                        {!! Form::label('answer', trans('common/labels.answer'), [
                            'class' => 'col-sm-2 control-label'
                        ]) !!}
                        <div class="col-sm-6">
                            {!! Form::text('answer[0][content]', old('answer[0][content]'), [
                                'class' => 'form-control',
                                'placeholder' => trans('common/placeholders.content')
                            ]) !!}
                        </div>

                        <div class="checkbox-remove">
                            <div class="col-sm-2">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::hidden('answer[0][is_correct]', config('answer.correct.false')) !!}
                                        {!! Form::checkbox(
                                            'answer[0][is_correct]',
                                            config('answer.correct.true'),
                                            null,
                                            ['class' => 'is_correct']
                                        ) !!}
                                        {{ trans('common/placeholders.is-correct') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="remove-answer btn btn-default" onclick="javascript:;">
                                    {{ trans('common/buttons.remove-answer') }}
                                </button>
                            </div>
                        </div>
                        
                    </div>
                @endif
                </div>
                <!-- End of answers section -->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="add-answer" class="btn btn-default">
                            {{ trans('common/buttons.add-answer') }}
                        </button>
                        {!! Form::submit(trans('common/buttons.create'), [
                            'class' => 'btn btn-primary'
                        ]) !!}
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>

    <script>
        var questionType = JSON.parse('{!! json_encode(config('options.question-type')) !!}');

        var remove = "{{ trans('common/buttons.remove-answer') }}";
        var answer = "{{ trans('common/labels.answer') }}";
        var content = "{{ trans('common/placeholders.content') }}";
        var is_correct = "{{ trans('common/placeholders.is-correct') }}";
    </script>
@endsection
