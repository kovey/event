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
use Kovey\Event\Listener\Event;

class EventManagerTest extends TestCase
{
    public function testDispatch()
    {
        $eventManager = new EventManager(array(
            'test' => Event::class,
            'test2' => Event::class
        ));

        $run1 = '';
        $run2 = '';
        $result = $eventManager->addEvent('test', function (Event $event) use (&$run1) {
            $run1 = $event->getName();
        });

        $result = $eventManager->addEvent('test2', function (Event $event) use (&$run2) {
            $run2 = $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $event1 = new Event();
        $event1->setName('framework');

        $eventManager->dispatch($event);
        $this->assertEquals('kovey', $run1);
        $this->assertEquals('kovey', $run2);
        $eventManager->dispatch($event1);
        $this->assertEquals('framework', $run1);
        $this->assertEquals('framework', $run2);
    }

    public function testDispatchStop()
    {
        $eventManager = new EventManager(array(
            'test' => Event::class,
            'test2' => Event::class
        ));
        $run1 = '';
        $run2 = '';
        $result = $eventManager->addEvent('test', function (Event $event) use (&$run1) {
            $run1 = $event->getName();
        });

        $result = $eventManager->addEvent('test2', function (Event $event) use (&$run2) {
            $run2 = $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');
        $event->stopPropagation();

        $event1 = new Event();
        $event1->setName('framework');

        $eventManager->dispatch($event);
        $this->assertEquals('kovey', $run1);
        $this->assertEquals('', $run2);
        $eventManager->dispatch($event1);
        $this->assertEquals('framework', $run1);
        $this->assertEquals('framework', $run2);
    }

    public function testDispatchWithReturn()
    {
        $eventManager = new EventManager(array(
            'test' => Event::class,
            'test2' => Event::class
        ));
        $result = $eventManager->addEvent('test', function (Event $event) use (&$run1) {
            return $event->getName();
        });

        $result = $eventManager->addEvent('test2', function (Event $event) use (&$run2) {
            return 'kovey ' . $event->getName();
        });

        $event = new Event();
        $event->setName('kovey');

        $event1 = new Event();
        $event1->setName('framework');

        $this->assertEquals('kovey', $eventManager->dispatchWithReturn($event));
        $this->assertEquals('framework', $eventManager->dispatchWithReturn($event1));
    }
}
