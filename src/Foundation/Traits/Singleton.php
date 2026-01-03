<?php

namespace TestProject\CasinoCards\Foundation\Traits;

/**
 * Singleton Trait
 */
trait Singleton
{
    /**
     * Singleton constructor.
     */
    private function __construct()
    {
    }

    /**
     * Get class instance.
     *
     * @return object|null Instance.
     */
    final public static function instance($args = []): ?object
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static($args);
        }

        return $instance;
    }

    /**
     * Prevent cloning.
     */
    final public function __clone()
    {
    }

    /**
     * Prevent unserializing.
     */
    final public function __wakeup()
    {
    }
}
