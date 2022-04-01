<?php

namespace App\Listeners;

class FirstListener
{
    public function __invoke()
    {
        echo "First";
    }
}
