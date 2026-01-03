<?php

namespace TestProject\CasinoCards\Hooks;

use TestProject\CasinoCards\Api\CachingCasinoProvider;
use TestProject\CasinoCards\Api\Clients\CartableApiClient;
use TestProject\CasinoCards\Api\HttpClient;

/**
 * CronHooks class
 */
class CronHooks
{
    public const REVALIDATE_HOOK = 'tp_casino_cards_revalidate_cache';

    /**
     * @return void
     */
    public function register(): void
    {
        add_action(self::REVALIDATE_HOOK, [$this, 'handleRevalidate'], 10, 1);
    }

    /**
     * @param string $key
     * @return void
     */
    public function handleRevalidate(string $key): void
    {
        $apiClient = new CartableApiClient(new HttpClient());
        $cache = new CachingCasinoProvider($apiClient);

        $cache->revalidate($key);
    }
}
