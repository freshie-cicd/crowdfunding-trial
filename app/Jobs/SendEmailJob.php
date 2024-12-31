<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3; // Maximum attempts
    public $backoff = 5; // Delay between retry attempts
    public $timeout = 15; // Maximum seconds the job can run before timing out
    public $maxExceptions = 3; // Maximum number of unhandled exceptions allowed

    public function __construct(protected $email, protected $mailable) {}

    public function handle()
    {
        Mail::to($this->email)->send($this->mailable);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Email sending failed', [
            'email' => $this->email,
            'mailable' => get_class($this->mailable),
            'error' => $exception->getMessage(),
        ]);
    }
}
