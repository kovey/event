<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-06 11:42:07
 *
 */
namespace Kovey\Event\Listener;

use PHPUnit\Framework\TestCase;
use Kovey\Event\Exception\EventException;

require_once __DIR__ . '/Event.php';

class ListenerTest extends TestCase
{
    public function testGetEvents()
    {
        $listener = new Listener();
        $result = $listener->addEvent(Event::class, function (Event $event) {
        });
        $this->assertInstanceOf(Listener::class, $result);
        $this->assertEquals(array('Kovey\Event\Listener\Event'), array_values($listener->getEvents()));
    }

    public function testTrigger()
    {
        $listener = new Listener();
        $result = $listener->addEvent(Event::class, function (Event $event) {
            $this->assertEquals('kovey', $event->getName());
            $this->assertTrue($event->isPropagationStopped());
            return 'event';
        });

        $event = new Event();
        $event->setName('kovey');
        $event->stopPropagation();
        $this->assertEquals('event', $listener->trigger($event));
    }

    public function testTriggerFailure()
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Kovey\Event\Listener\Event is not listen');

        $listener = new Listener();
        $result = $listener->addEvent(Listener::class, function (Event $event) {
            $this->assertEquals('kovey', $event->getName());
            $this->assertTrue($event->isPropagationStopped());
            return 'event';
        });

        $event = new Event();
        $event->setName('kovey');
        $event->stopPropagation();
        $this->assertEquals('event', $listener->trigger($event));
    }
}
