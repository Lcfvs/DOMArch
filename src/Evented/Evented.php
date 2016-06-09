<?php
namespace DOMArch;

trait Evented
{
    protected $_listeners = [];

    public function on($event, callable $listener) {
        if ($event !== 'newListener') {
            $this->emit('newListener', $event, $listener);
        }

        if (empty($this->_listeners[$event])) {
            $this->_listeners[$event] = [];
        }

        $this->_listeners[$event][] = $listener;

        return $this;
    }

    public function once($event, callable $listener) {
        $onceListener = function ()
        use (&$onceListener, $event, $listener) {
            $this->removeListener($event, $onceListener);

            $listener(...func_get_args());
        };

        return $this->on($event, $onceListener);
    }

    public function removeListener($event, callable $listener) {
        if (empty($this->_listeners[$event])) {
            return $this;
        }

        $index = array_search($listener, $this->_listeners[$event], true);

        if (false !== $index) {
            $this->emit('removedListener', $event, $listener);

            unset($this->_listeners[$event][$index]);
        }

        return $this;
    }

    public function removeAllListeners($event = null) {
        $listeners = $this->_listeners;

        if (is_null($event)) {
            $events = array_keys($listeners);
        } else {
            $events = [$event];
        }

        foreach ($events as $name) {
            if (empty($listeners[$name])) {
                continue;
            }

            foreach ($listeners[$name] as $listener) {
                $this->removeListener($name, $listener);
            }
        }

        return $this;
    }

    public function listeners($event) {
        return $this->_listeners[$event] ?? [];
    }

    public function emit($event, ...$arguments) {
        if ($event !== 'newEvent') {
            $this->emit('newEvent', $event, ...$arguments);
        }

        foreach ($this->listeners($event) as $listener) {
            $listener->call($this, ...$arguments);
        }

        return $this;
    }
}