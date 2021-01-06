<?php
/**
 * @description listener interface
 *
 * @package Kovey\Event
 *
 * @author kovey
 *
 * @time 2021-01-06 11:08:30
 *
 */
namespace Kovey\Event;

interface ListenerInterface
{
    /**
     * @description get all events
     *
     * @return Array
     */
    public function getEvents() : Array;

    /**
     * @description trigger events
     * 
     * @return mixed
     */
    public function trigger(EventInterface $event);

    /**
     * @description add event
     *
     * @return ListenerInterface
     */
    public function addEvent(string $event, callable | Array $callback) : ListenerInterface;
}
