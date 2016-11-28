<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\SuggestQuestionRepositoryInterface;
use Auth;

class SuggestQuestionRepository extends BaseRepository implements SuggestQuestionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Question';
    }

    public function createSuggestQuestion(array $input)
    {
        $data['suggest_question'] = [
            'user_id' => Auth::user()->id,
            'subject_id' => $input['subject'],
            'content' => $input['content'],
            'status' => config('question.status.inactive'),
            'type' => $input['type'],
        ];
 
        return $this->model->create($data['suggest_question'])
            ->systemAnswers()->createMany($input['answer']);
    }

    public function viewListSuggestQuestion($column, $option)
    {
        $data = $this->model->where($column, $option)->with('subject')
            ->paginate(config('repository.pagination.limit', 10));

        return $data;
    }
}
