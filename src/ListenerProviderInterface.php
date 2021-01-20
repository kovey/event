<?php
/**
 * @description listener provider interface
 *
 * @package Kovey\Event
 *
 * @author kovey
 *
 * @time 2021-01-06 11:10:21
 *
 */
namespace Kovey\Event;

interface ListenerProviderInterface
{
    /**
     * @description get listeners
     *
     * @return Array
     */
    public function getListeners(EventInterface $event) : Array;

    /**
     * @description get first listener
     * 
     * @return ListenerInterface
     */
    public function getFirstListener(EventInterface $event) : ListenerInterface;

    /**
     * @description add listeners
     * 
     * @return ListenerProviderInterface
     */
    public function addListener(ListenerInterface $listener) : ListenerProviderInterface;
}
