<script>
    var questionType = JSON.parse('{!! json_encode(config('options.question-type')) !!}');

    var remove = "{{ trans('common/buttons.remove-answer') }}";
    var answer = "{{ trans('common/labels.answer') }}";
    var content = "{{ trans('common/placeholders.content') }}";
    var is_correct = "{{ trans('common/placeholders.is-correct') }}";
</script>