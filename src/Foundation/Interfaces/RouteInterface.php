<?php

namespace TestProject\CasinoCards\Foundation\Interfaces;

/**
 * RouteInterface interface
 */
interface RouteInterface
{
    /**
     * @return string
     */
    public function getNamespace(): string;

    /**
     * @return array
     */
    public function getRoutes(): array;
}
