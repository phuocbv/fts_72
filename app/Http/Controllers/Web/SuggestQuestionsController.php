<?php

namespace App\Http\Controllers\Web;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestQuestion;
use App\Repositories\Contracts\SuggestQuestionRepositoryInterface as SuggestQuestionRepository;
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
        SuggestQuestionRepository $suggestQuestionsRepository,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
