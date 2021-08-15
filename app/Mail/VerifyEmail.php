<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $token;

    /**
     * @var int
     */
    private int $seconds;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token , int $seconds)
    {
        $this->token = $token;
        $this->seconds = $seconds;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('email')->with(['token' => $this->token , 'seconds' => $this->seconds]);
    }

}
