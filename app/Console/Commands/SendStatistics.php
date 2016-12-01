<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\Statistics;
use Illuminate\Contracts\Mail\Mailer;
use App\Models\User;
use App\Repositories\Contracts\ExamRepositoryInterface;

class SendStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stat:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send stat to admin';
    /**
     * The e-mail service.
     *
     * @var Statistics Email
     */
    protected $examRepository;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        Mailer $mail,
        ExamRepositoryInterface $examRepository
    )
    {
        parent::__construct();

        $this->mail = $mail;
        $this->examRepository = $examRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->mail->to(
            User::where('email', config('email.default'))->get()
        )->send(new Statistics($this->examRepository));
    }
}
