<?php

namespace App\Listeners;

use Hyqo\Events\Skippable;

class FourthListener implements Skippable
{
    public function __invoke()
    {
        echo "Fourth";
    }

    public function shouldSkip(): bool
    {
        return false;
    }
}
