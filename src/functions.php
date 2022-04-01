<?php

namespace Hyqo\Events;

function dispatch(object $event)
{
    Dispatcher::dispatch($event);
}

function event(string $eventClassname): object
{
    return new Event($eventClassname);
}
