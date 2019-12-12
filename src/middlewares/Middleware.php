<?php


namespace Middleware;


use Resource\Request;

abstract class Middleware
{
    /**
     * @var Middleware
     */
    private $next;

    public function link(Middleware $middleware): Middleware
    {
        $this->next = $middleware;

        return $this;
    }

    public function check(): bool
    {
        if (!$this->next) {
            return true;
        }

        return $this->next->check();
    }

    public function getNext(): Middleware
    {
        return $this->next;
    }
}