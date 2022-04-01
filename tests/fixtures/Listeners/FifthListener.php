<?php

namespace App\Listeners;

use Hyqo\Events\Skippable;

class FifthListener
{
    private $message;

    public function __construct(string $message = 'Fifth')
    {
        $this->message = $message;
    }

    public function __invoke()
    {
        echo $this->message;
    }
}
