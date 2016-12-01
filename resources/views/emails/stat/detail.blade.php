{{ trans('messages.total', ['total' => $exams->count()]) }}
<table class="table">
	<tr>
		<td>{{ trans('common/labels.id') }}</td>	
		<td>{{ trans('common/labels.name') }}</td>	
		<td>{{ trans('common/labels.score') }}</td>	
		<td>{{ trans('common/labels.status') }}</td>	
	</tr>
	@foreach ($exams as $exam)
	<tr>
		<td>{{ $exam->id }}</td>
		<td>{{ $exam->user->name }}</td>
		<td>{{ $exam->score }}</td>
		<td>{{ trans('front-end/exam.states.' . $exam->status) }}</td>
	</tr>
	@endforeach
</table>

