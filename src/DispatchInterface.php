<?php
/**
 * @description event dispatch interface
 *
 * @package Kovey\Event
 *
 * @author kovey
 *
 * @time 2021-01-06 10:03:54
 *
 */
namespace Kovey\Event;

interface DispatchInterface
{
    /**
     * @description dispatch event
     *
     * @param EventInterface $event
     *
     * @return DispatchInterface
     */
    public function dispatch(EventInterface $event) : DispatchInterface;

    /**
     * @description dispatch event with return
     *
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function dispatchWithReturn(EventInterface $event);
}
