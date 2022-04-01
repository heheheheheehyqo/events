<?php

namespace App\Listeners;

use Hyqo\Events\Skippable;

class ThirdListener implements Skippable
{
    public function __invoke()
    {
        echo "Third";
    }

    public function shouldSkip(): bool
    {
        return true;
    }
}
