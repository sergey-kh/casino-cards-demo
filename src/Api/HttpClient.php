<?php

namespace TestProject\CasinoCards\Api;

use Exception;
use TestProject\CasinoCards\Config\PluginConfig;
use TestProject\CasinoCards\Foundation\Interfaces\HttpClientInterface;
use WP_Error;

/**
 * HttpClient class
 */
class HttpClient implements HttpClientInterface
{
    private int $timeout;

    public function __construct($timeout = 30)
    {
        $this->timeout = (int) apply_filters(PluginConfig::HOOKS_PREFIX . 'http_client_timeout', $timeout);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function get(string $url, array $options = []): array
    {
        return $this->request('GET', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function post(string $url, array $options = []): array
    {
        return $this->request('POST', $url, $options);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function request(string $method, string $url, array $options = []): array
    {
        if ($url === '') {
            throw new Exception('Request path cannot be empty.');
        }

        $args = [
            'method' => strtoupper($method),
            'headers' => $options['headers'] ?? [],
            'timeout' => $this->timeout,
        ];

        $this->applyAuth($args, $options);
        $this->applyQuery($method, $url, $options);
        $this->applyBody($method, $args, $options);

        $response = wp_remote_request($url, $args);
        if ($response instanceof WP_Error) {
            throw new Exception(sprintf('HTTP request error: %s', $response->get_error_message()));
        }

        $status = (int) wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        if ($status < 200 || $status >= 300) {
            throw new Exception(sprintf('Unexpected HTTP status code: %d "%s"', $status, $body));
        }

        return [
            'status' => (int) wp_remote_retrieve_response_code($response),
            'body' => $body,
            'headers' => (array) wp_remote_retrieve_headers($response),
            'raw' => $response,
        ];
    }

    /**
     * @param array $args
     * @param array $options
     * @return void
     */
    private function applyAuth(array &$args, array $options): void
    {
        if (empty($options['auth'])) {
            return;
        }

        [$user, $pass] = $options['auth'];
        $args['headers']['Authorization'] = 'Basic ' . base64_encode($user . ':' . $pass);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return void
     */
    private function applyQuery(string $method, string &$url, array $options): void
    {
        if ($method !== 'GET' || empty($options['query']) || ! is_array($options['query'])) {
            return;
        }

        $url = add_query_arg($options['query'], $url);
    }

    /**
     * @param string $method
     * @param array $args
     * @param array $options
     * @return void
     */
    private function applyBody(string $method, array &$args, array $options): void
    {
        if ($method === 'GET') {
            return;
        }

        if (! empty($options['json'])) {
            $args['body'] = wp_json_encode($options['json']);
            $args['headers']['Content-Type'] = 'application/json';
            return;
        }

        if (! empty($options['form_params'])) {
            $args['body'] = $options['form_params'];
            $args['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
        }
    }
}
