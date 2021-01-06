<?php
/**
 * @description event interface
 *
 * @package Kovey\Event
 *
 * @author kovey
 *
 * @time 2021-01-06 10:06:53
 *
 */
namespace Kovey\Event;

interface EventInterface
{
    /**
     * @description propagation stopped
     *
     * @return bool
     */
    public function isPropagationStopped() : bool;

    /**
     * @description stop propagation
     *
     * @return EventInterface
     */
    public function stopPropagation() : EventInterface;
}
