<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as VendorResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedResetPasswordNotification extends VendorResetPassword implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    public $tries = 3; // Maximum attempts
    public $backoff = 5; // Delay between retry attempts
    public $timeout = 15; // Maximum seconds the job can run before timing out
    public $maxExceptions = 3; // Maximum number of unhandled exceptions allowed

    public function __construct(#[\SensitiveParameter] $token)
    {
        parent::__construct($token);

        $this->delay(3);
    }

    public function viaQueues()
    {
        return [
            'mail' => 'high',
        ];
    }
}
