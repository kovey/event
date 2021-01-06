<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-06 13:00:54
 *
 */
namespace Kovey\Event\Listener;

use PHPUnit\Framework\TestCase;
use Kovey\Event\Exception\EventException;

require_once __DIR__ . '/Event.php';

class ListenerProviderTest extends TestCase
{
    public function testGetListeners()
    {
        $listener = new Listener();
        $result = $listener->addEvent(Event::class, function (Event $event) {
            return $event->getName();
        });

        $listener1 = new Listener();
        $result = $listener1->addEvent(Event::class, function (Event $event) {
            return 'kovey ' . $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $event1 = new Event();
        $event1->setName('framework');

        $provider = new ListenerProvider();
        $provider->addListener($listener)
            ->addListener($listener1);

        $listeners = $provider->getListeners($event);
        $this->assertEquals(2, count($listeners));
        $this->assertEquals(2, count($provider->getListeners($event1)));
        $this->assertEquals('kovey', $listeners[0]->trigger($event));
        $this->assertEquals('kovey framework', $listeners[1]->trigger($event1));
    }

    public function testGetFirstListener()
    {
        $listener = new Listener();
        $result = $listener->addEvent(Event::class, function (Event $event) {
            return $event->getName();
        });

        $listener1 = new Listener();
        $result = $listener1->addEvent(Event::class, function (Event $event) {
            return 'kovey ' . $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $event1 = new Event();
        $event1->setName('framework');

        $provider = new ListenerProvider();
        $provider->addListener($listener)
            ->addListener($listener1);

        $this->assertEquals('kovey', $provider->getFirstListener($event)->trigger($event));
        $this->assertEquals('framework', $provider->getFirstListener($event1)->trigger($event1));
    }

    public function testGetFirstListenerFailure()
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Kovey\Event\Listener\Event has no listener');
        $listener = new Listener();
        $result = $listener->addEvent(Listener::class, function (Event $event) {
            return $event->getName();
        });

        $listener1 = new Listener();
        $result = $listener1->addEvent(Listener::class, function (Event $event) {
            return 'kovey ' . $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $provider = new ListenerProvider();
        $provider->addListener($listener)
            ->addListener($listener1);

        $provider->getFirstListener($event)->trigger($event);
    }
}
