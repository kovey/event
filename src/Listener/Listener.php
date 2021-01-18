<?php
/**
 * @description  listener
 *
 * @package Kovey\Event\Listener
 *
 * @author kovey
 *
 * @time 2021-01-06 11:13:35
 *
 */
namespace Kovey\Event\Listener;

use Kovey\Event\ListenerInterface;
use Kovey\Event\Exception\EventException;
use Kovey\Event\EventInterface;

class Listener implements ListenerInterface
{
    /**
     * @description events
     *
     * @var Array
     */
    private Array $events;

    /**
     * @description callbacks
     *
     * @var Array
     */
    private Array $callbacks;

    public function __construct()
    {
        $this->events = array();
        $this->callbacks = array();
    }

    /**
     * @description get all events
     *
     * @return Array
     */
    public function getEvents() : Array
    {
        return $this->events;
    }

    /**
     * @description trigger events
     * 
     * @return mixed
     */
    public function trigger(EventInterface $event) : mixed
    {
        if (!isset($this->callbacks[$event::class])) {
            throw new EventException(sprintf('%s is not listen.', $event::class));
        }

        return call_user_func($this->callbacks[$event::class], $event);
    }

    /**
     * @description add event
     *
     * @return ListenerInterface
     */
    public function addEvent(string $event, callable | Array $callback) : ListenerInterface
    {
        $this->callbacks[$event] = $callback;
        $this->events[$event] = $event;

        return $this;
    }
}
