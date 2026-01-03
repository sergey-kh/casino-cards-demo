<?php

namespace TestProject\CasinoCards\Api\Clients;

use Exception;
use TestProject\CasinoCards\Config\PluginConfig;
use TestProject\CasinoCards\Foundation\Interfaces\CasinoApiInterface;
use TestProject\CasinoCards\Foundation\Interfaces\HttpClientInterface;

/**
 * CartableApiClient class
 */
class CartableApiClient implements CasinoApiInterface
{
    private const BASE_URL = 'https://2025q2wpdev.cartable.info';

    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function getCasinoResponse(string $id): array
    {
        return $this->request("/casinos/{$id}", true);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCasinoListResponse(): array
    {
        return $this->request('/casinos', true);
    }

    /**
     * @param string $path
     * @param bool $private
     * @return array
     * @throws Exception
     */
    private function request(string $path, bool $private = false): array
    {
        $options = $private ? $this->getAuthOptions() : [];
        $response = $this->httpClient->get(self::BASE_URL . '/' . ltrim($path, '/'), $options);
        $data = json_decode($response['body'], true);
        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($data)) {
            throw new Exception('Invalid API response: invalid body JSON');
        }

        return $data ?: [];
    }

    /**
     * @return array
     */
    private function getAuthOptions(): array
    {
        $username = PluginConfig::getOption(PluginConfig::CARTABLE_API_USERNAME);
        $password = PluginConfig::getOption(PluginConfig::CARTABLE_API_PASSWORD);

        if ($username === '' || $password === '') {
            return [];
        }

        return [
            'auth' => [$username, $password],
            'headers' => ['Accept' => 'application/json'],
        ];
    }
}
