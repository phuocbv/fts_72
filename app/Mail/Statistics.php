<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Contracts\ExamRepositoryInterface;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts;
use DB;

class Statistics extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The exam instance.
     *
     * @var exam
     */
    public $examRepository;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ExamRepositoryInterface $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $exams  = $this->examRepository->where('created_at', Carbon::now()->toDateTimeString())->get();
        return $this->view('emails.stat.detail', [
            'exams' => $exams,
        ]);
    }
}
