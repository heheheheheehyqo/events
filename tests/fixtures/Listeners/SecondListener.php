<?php

namespace App\Listeners;

class SecondListener
{
    public function __invoke()
    {
        echo "Second";
    }
}
