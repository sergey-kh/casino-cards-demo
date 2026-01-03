<?php

namespace TestProject\CasinoCards\Foundation\Interfaces;

/**
 * HttpClientInterface interface
 */
interface HttpClientInterface
{
    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function get(string $url, array $options = []): array;

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function post(string $url, array $options = []): array;

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     */
    public function request(string $method, string $url, array $options = []): array;
}
