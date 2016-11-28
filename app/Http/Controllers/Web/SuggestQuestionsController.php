<?php

namespace App\Http\Controllers\Web;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestQuestion;
use App\Repositories\Contracts\QuestionRepositoryInterface as QuestionRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface as SubjectRepository;
use Exception;
use Log;
use Auth;
use DB;

class SuggestQuestionsController extends BaseController
{
    /**
     * @var SuggestQuestion
     */
    private $suggestQuestionsRepository;
    private $subjectRepository;
 
    public function __construct (
        QuestionRepository $suggestQuestionsRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->suggestQuestionsRepository = $suggestQuestionsRepository;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['suggestQuestions'] = $this->suggestQuestionsRepository
            ->viewListSuggestQuestion('user_id', Auth::user()->id);

        return view('web.suggest-questions.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->viewData['subject'] = $this->subjectRepository->lists('name', 'id');

        return view('web.suggest-questions.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuggestQuestion $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->only('subject', 'content', 'active', 'type', 'answer');
            $flag = false;
            foreach ($data['answer'] as $answer) {

                if ($answer['is_correct'] == config('answer.correct.true')) {
                    $flag = true;
                }
            }

            if ($flag) {
                $this->suggestQuestionsRepository->createSuggestQuestion($data);
                DB::commit();

                return redirect()->action('Web\SuggestQuestionsController@index')
                    ->with('status', trans('messages.success.create'));
            } else {
                return redirect()->action('Web\SuggestQuestionsController@create')
                    ->withErrors(trans('front-end/users.suggest-question.answer-emty'));
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e);

            return redirect()->action('Web\SuggestQuestionsController@create')
                ->withErrors(trans('front-end/users.suggest-question.create-fail'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sgQuestions = $this->suggestQuestionsRepository->showSuggestQuestion($id);

        if ($sgQuestions->user_id == Auth::user()->id) {
            $this->viewData['sgQuestions'] = $sgQuestions;

            return view('web.suggest-questions.detail', $this->viewData);
        }

        return redirect()->action('Web\SuggestQuestionsController@index')
            ->withErrors(trans('front-end/users.suggest-question.show-permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->viewData['subject'] = $this->subjectRepository->lists('name', 'id');
        $sgQuestions = $this->suggestQuestionsRepository->showSuggestQuestion($id);

        if ($sgQuestions->user_id == Auth::user()->id && $sgQuestions->status == config('question.status.inactive')) {
            $this->viewData['sgQuestions'] = $sgQuestions;

            return view('web.suggest-questions.edit', $this->viewData);
        }

        return redirect()->action('Web\SuggestQuestionsController@index')
            ->withErrors(trans('front-end/users.suggest-question.edit-permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuggestQuestion $request, $id)
    {
        $this->viewData['subject'] = $this->subjectRepository->lists('name', 'id');
        $sgQuestions = $this->suggestQuestionsRepository->showSuggestQuestion($id);

        if ($sgQuestions->user_id != Auth::user()->id || $sgQuestions->status != config('question.status.inactive')) {
            return redirect()->action('Web\SuggestQuestionsController@index')
                ->withErrors(trans('front-end/users.suggest-question.edit-permission'));
        }

        DB::beginTransaction();

        try {
            $data = $request->only('subject', 'content', 'type', 'answer');
            $flag = false;
            $active = config('question.status.inactive');
            
            foreach ($data['answer'] as $answer) {
                if ($answer['is_correct'] == config('answer.correct.true')) {
                    $flag = true;
                    break;
                }
            }

            if ($flag) {
                $this->suggestQuestionsRepository->updateQuestion($data, $id, $active);
                DB::commit();

                return redirect()->back()->with('status', trans('messages.success.update'));
            }

            return redirect()->back()->withErrors(trans('front-end/users.suggest-question.answer-emty'));
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e);

            return redirect()->back()
                ->withErrors(trans('front-end/users.suggest-question.update-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
