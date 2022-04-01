<?php

namespace Hyqo\Events;

use Hyqo\Container\Container;

class Dispatcher
{
    protected static $container;

    protected static $events = [];

    public static function setContainer(Container $container)
    {
        self::$container = $container;
    }

    public static function listen(string $eventClassname, string $listenerClassname): void
    {
        if (array_key_exists($eventClassname, self::$events)) {
            self::$events[$eventClassname][] = $listenerClassname;
        } else {
            self::$events[$eventClassname] = [$listenerClassname];
        }
    }

    public static function dispatch(object $event): void
    {
        foreach (self::$events[get_class($event)] ?? [] as $listener) {
            $object = (null === self::$container) ? new $listener : self::$container->get($listener);

            if (!is_callable($object)) {
                continue;
            }

            if ($object instanceof Skippable) {
                if (method_exists($object, 'shouldSkip') && !$object->shouldSkip($event)) {
                    $object($event);
                }
            } else {
                $object($event);
            }
        }
    }

    public static function getEvents(): array
    {
        return self::$events;
    }
}
