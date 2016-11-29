<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use DB;
use App\Models\Exam;

class ChartsController extends BaseController
{
    public function __construct() {
        $this->viewData['title'] = trans('admin/chart.chart');
    }

    public function index()
    {
        $chart = new Lavacharts; // See note below for Laravel
        $exams = $chart->DataTable();
        $data['exams_result'] = Exam::select(DB::raw('count(*) as exam_count'), 'score')
            ->groupBy('score')
            ->get();

        $exams->addStringColumn('Exam')
            ->addNumberColumn('Exam');

            foreach ($data['exams_result'] as $key => $value) {
                $exams->addRow([$value->score, $value->exam_count]);
            }

        $chart->AreaChart('Exams', $exams, [
            'title' => trans('admin/chart.chart-exam-of-score')
        ]);
        $this->viewData['chart'] = $chart;

        return view('admin.chart.index', $this->viewData);
    }
}
