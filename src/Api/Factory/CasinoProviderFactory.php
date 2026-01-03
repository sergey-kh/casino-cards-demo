<?php

namespace TestProject\CasinoCards\Api\Factory;

use Exception;
use RuntimeException;
use TestProject\CasinoCards\Api\Adapter\CartableCasinoAdapter;
use TestProject\CasinoCards\Api\CachingCasinoProvider;
use TestProject\CasinoCards\Api\Clients\CartableApiClient;
use TestProject\CasinoCards\Foundation\Interfaces\CasinoProviderInterface;
use TestProject\CasinoCards\Foundation\Interfaces\HttpClientInterface;

/**
 * CasinoProviderFactory class
 */
class CasinoProviderFactory
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws Exception
     */
    public function create(string $provider): CasinoProviderInterface
    {
        return match ($provider) {
            'cartable' => new CartableCasinoAdapter(
                new CachingCasinoProvider(new CartableApiClient($this->httpClient))
            ),
            default => throw new RuntimeException('Unknown provider'),
        };
    }
}
