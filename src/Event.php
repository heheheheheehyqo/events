<?php

namespace Hyqo\Events;

class Event
{
    private $eventClassname;

    public function __construct(string $eventClassname)
    {
        $this->eventClassname = $eventClassname;
    }

    public function listener(string $listenerClassname): Event
    {
        Dispatcher::listen($this->eventClassname, $listenerClassname);

        return $this;
    }
}
