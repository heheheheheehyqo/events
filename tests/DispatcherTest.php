<?php

namespace Hyqo\Events\Test;

use App\Events\BarEvent;
use App\Events\FooEvent;
use App\Listeners\FifthListener;
use App\Listeners\FirstListener;
use App\Listeners\SecondListener;
use App\Listeners\ThirdListener;
use App\Listeners\FourthListener;

use Hyqo\Container\Container;
use Hyqo\Events\Dispatcher;
use PHPUnit\Framework\TestCase;

use function Hyqo\Events\dispatch;
use function Hyqo\Events\event;

class DispatcherTest extends TestCase
{
    protected function setUp(): void
    {
        $reflected = new \ReflectionClass(Dispatcher::class);

        $reflectedProperty = $reflected->getProperty('events');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue([]);

        $reflectedProperty = $reflected->getProperty('container');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue(null);
    }

    public function test_config(): void
    {
        event(FooEvent::class)
            ->listener(FirstListener::class)
            ->listener(SecondListener::class);

        $this->assertEquals([
            FooEvent::class => [
                FirstListener::class,
                SecondListener::class,
            ]
        ], Dispatcher::getEvents());
    }

    public function test_fire(): void
    {
        event(FooEvent::class)
            ->listener(FirstListener::class)
            ->listener(SecondListener::class);

        event(BarEvent::class)
            ->listener(ThirdListener::class)
            ->listener(FourthListener::class);

        dispatch(new FooEvent());
        dispatch(new BarEvent());

        $this->expectOutputString('FirstSecondFourth');
    }

    public function test_fire_with_container(): void
    {
        $container = new Container();
        $container->set(FifthListener::class, new FifthListener('Hello from Fifth'));

        Dispatcher::setContainer($container);

        event(FooEvent::class)
            ->listener(FifthListener::class);

        dispatch(new FooEvent());

        $this->expectOutputString('Hello from Fifth');
    }
}
