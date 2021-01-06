<?php
/**
 * @description  event dispatch
 *
 * @package Kovey\Event
 *
 * @author kovey
 *
 * @time 2021-01-06 10:02:50
 *
 */
namespace Kovey\Event;

class Dispatch implements DispatchInterface
{ 
    private ListenerProviderInterface $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @description dispatch event
     *
     * @param EventInterface $event
     *
     * @return DispatchInterface
     */
    public function dispatch(EventInterface $event) : DispatchInterface
    {
        foreach ($this->listenerProvider->getListeners($event) as $listener) {
            $listener->trigger($event);
            if ($event->isPropagationStopped()) {
                break;
            }
        }

        return $this;
    }

    /**
     * @description dispatch event with return
     *
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function dispatchWithReturn(EventInterface $event)
    {
        return $this->listenerProvider->getFirstListener($event)->trigger($event);
    }
}
