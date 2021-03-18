<?php
/**
 * @description event manager
 *
 * @package Kovey\Event
 *
 * @author kovey
 *
 * @time 2021-02-02 11:18:12
 *
 */
namespace Kovey\Event;

use Kovey\Event\Listener\Listener;
use Kovey\Event\Listener\ListenerProvider;

class EventManager
{
    /**
     * @description event dispatcher
     *
     * @var Dispatch
     */
    private Dispatch $dispatch;

    /**
     * @description event listener provider
     *
     * @var ListenerProvider
     */
    private ListenerProvider $provider;

    /**
     * @description event supports
     *
     * @var Array
     */
    private Array $events = array();

    /**
     * @description events listened
     *
     * @var Array
     */
    private Array $onEvents;

    /**
     * @description event class listened
     *
     * @var Array
     */
    private Array $onClassEvents;

    public function __construct(Array $events = array())
    {
        $this->provider = new ListenerProvider();
        $this->dispatch = new Dispatch($this->provider);
        $this->onEvents = array();
        $this->onClassEvents = array();
        $this->events = $events;
    }

    public function addEvent(string $type, callable | Array $fun) : EventManager
    {
        if (!isset($this->events[$type])) {
            return $this;
        }

        if (!is_callable($fun)) {
            return $this;
        }

        $listener = new Listener();
        $listener->addEvent($this->events[$type], $fun);
        $this->provider->addListener($listener);
        $this->onEvents[$type] = 1;
        $this->onClassEvents[$this->events[$type]] = 1;

        return $this;
    }

    public function dispatch(EventInterface $event) : void
    {
        $this->dispatch->dispatch($event);
    }

    public function dispatchWithReturn(EventInterface $event) : mixed
    {
        return $this->dispatch->dispatchWithReturn($event);
    }

    public function listened(string $type) : bool
    {
        return isset($this->onEvents[$type]);
    }

    public function addSupportEvents(Array $events) : EventManager
    {
        foreach ($events as $event => $name) {
            $this->events[$event] = $name;
        }

        return $this;
    }

    public function listenedByClass(string $class) : bool
    {
        return isset($this->onClassEvents[$class]);
    }
}
