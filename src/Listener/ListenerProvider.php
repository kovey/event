<?php
/**
 * @description  listener provider
 *
 * @package Kovey\Event\Listener
 *
 * @author kovey
 *
 * @time 2021-01-06 11:27:48
 *
 */
namespace Kovey\Event\Listener;

use Kovey\Event\ListenerProviderInterface;
use Kovey\Event\ListenerInterface;
use Kovey\Event\EventInterface;
use Kovey\Event\Exception\EventException;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @description events
     *
     * @var Array
     */
    private Array $events;

    public function __construct()
    {
        $this->events = array();
    }

    /**
     * @description get listeners
     *
     * @return Array
     */
    public function getListeners(EventInterface $event) : Array
    {
        return $this->events[$event::class] ?? array();
    }

    /**
     * @description get first listener
     * 
     * @return ListenerInterface
     */
    public function getFirstListener(EventInterface $event) : ListenerInterface
    {
        $listeners = $this->getListeners($event);
        if (empty($listeners)) {
            throw new EventException(sprintf('%s has no listener', $event::class));
        }

        return $listeners[0];
    }

    /**
     * @description add listener
     * 
     * @return ListenerProviderInterface
     */
    public function addListener(ListenerInterface $listener) : ListenerProviderInterface
    {
        foreach ($listener->getEvents() as $event) {
            $this->events[$event] ??= array();
            $this->events[$event][] = $listener;
        }

        return $this;
    }
}
