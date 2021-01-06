<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-06 11:46:12
 *
 */
namespace Kovey\Event\Listener;

use Kovey\Event\EventInterface;

class Event implements EventInterface
{
    private bool $stopped = false;

    private string $name;

    /**
     * @description propagation stopped
     *
     * @return bool
     */
    public function isPropagationStopped() : bool
    {
        return $this->stopped;
    }

    /**
     * @description stop propagation
     *
     * @return EventInterface
     */
    public function stopPropagation() : EventInterface
    {
        $this->stopped = true;
        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
