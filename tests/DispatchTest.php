<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-06 13:27:12
 *
 */
namespace Kovey\Event;

require_once __DIR__ . '/Listener/Event.php';

use PHPUnit\Framework\TestCase;
use Kovey\Event\Listener\Listener;
use Kovey\Event\Listener\ListenerProvider;
use Kovey\Event\Listener\Event;

class DispatchTest extends TestCase
{
    public function testDispatch()
    {
        $listener = new Listener();
        $run1 = '';
        $run2 = '';
        $result = $listener->addEvent(Event::class, function (Event $event) use (&$run1) {
            $run1 = $event->getName();
        });

        $listener1 = new Listener();
        $result = $listener1->addEvent(Event::class, function (Event $event) use (&$run2) {
            $run2 = $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $event1 = new Event();
        $event1->setName('framework');

        $provider = new ListenerProvider();
        $provider->addListener($listener)
            ->addListener($listener1);

        $dispatch = new Dispatch($provider);
        $dispatch->dispatch($event);
        $this->assertEquals('kovey', $run1);
        $this->assertEquals('kovey', $run2);
        $dispatch->dispatch($event1);
        $this->assertEquals('framework', $run1);
        $this->assertEquals('framework', $run2);
    }

    public function testDispatchStop()
    {
        $listener = new Listener();
        $run1 = '';
        $run2 = '';
        $result = $listener->addEvent(Event::class, function (Event $event) use (&$run1) {
            $run1 = $event->getName();
        });

        $listener1 = new Listener();
        $result = $listener1->addEvent(Event::class, function (Event $event) use (&$run2) {
            $run2 = $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');
        $event->stopPropagation();

        $event1 = new Event();
        $event1->setName('framework');

        $provider = new ListenerProvider();
        $provider->addListener($listener)
            ->addListener($listener1);

        $dispatch = new Dispatch($provider);
        $dispatch->dispatch($event);
        $this->assertEquals('kovey', $run1);
        $this->assertEquals('', $run2);
        $dispatch->dispatch($event1);
        $this->assertEquals('framework', $run1);
        $this->assertEquals('framework', $run2);
    }

    public function testDispatchWithReturn()
    {
        $listener = new Listener();
        $result = $listener->addEvent(Event::class, function (Event $event) use (&$run1) {
            return $event->getName();
        });

        $listener1 = new Listener();
        $result = $listener1->addEvent(Event::class, function (Event $event) use (&$run2) {
            return 'kovey ' . $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $event1 = new Event();
        $event1->setName('framework');

        $provider = new ListenerProvider();
        $provider->addListener($listener)
            ->addListener($listener1);

        $dispatch = new Dispatch($provider);
        $this->assertEquals('kovey', $dispatch->dispatchWithReturn($event));
        $this->assertEquals('framework', $dispatch->dispatchWithReturn($event1));
    }
}
