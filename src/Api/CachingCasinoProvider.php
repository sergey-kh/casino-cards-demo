<?php

namespace TestProject\CasinoCards\Api;

use TestProject\CasinoCards\Config\PluginConfig;
use TestProject\CasinoCards\Foundation\Interfaces\CasinoApiInterface;
use TestProject\CasinoCards\Hooks\CronHooks;

/**
 * CachingCasinoProvider class
 */
class CachingCasinoProvider implements CasinoApiInterface
{
    public const CACHE_KEY_PREFIX = 'tp_casino_cache';

    private int $cacheTtl;
    private int $staleAfter;

    private CasinoApiInterface $casinoApi;

    /**
     * @param CasinoApiInterface $casinoApi
     */
    public function __construct(CasinoApiInterface $casinoApi)
    {
        $this->casinoApi = $casinoApi;

        $this->cacheTtl = (int) apply_filters(PluginConfig::HOOKS_PREFIX . 'api_cache_ttl', 24 * 60 * 60);
        $this->staleAfter = (int) apply_filters(PluginConfig::HOOKS_PREFIX . 'api_cache_stale_after', 12 * 60 * 60);
    }

    /**
     * @param string $id
     * @return array
     */
    public function getCasinoResponse(string $id): array
    {
        return $this->remember('casino_' . $id, [$this->casinoApi, 'getCasinoResponse'], [$id]);
    }

    /**
     * @return array
     */
    public function getCasinoListResponse(): array
    {
        return $this->remember('casino_list', [$this->casinoApi, 'getCasinoListResponse']);
    }

    /**
     * @param string $key
     * @param callable $callable
     * @param array $args
     * @return array
     */
    private function remember(string $key, callable $callable, array $args = []): array
    {
        $cacheKey = self::CACHE_KEY_PREFIX . '_' . $key;

        $payload = get_transient($cacheKey);
        if (is_array($payload)) {
            $age = time() - (int) ($payload['cached_at'] ?? 0);

            // TODO: Stale While Revalidate (not tested properly, just emphasized)
            if ($age < $this->cacheTtl) {
                if ($age >= $this->staleAfter) {
                    $this->scheduleRevalidate($key);
                }
                return $payload['data'];
            }
        }

        $data = call_user_func_array($callable, $args);

        set_transient($cacheKey, ['cached_at' => time(), 'data' => $data], $this->cacheTtl);

        return $data;
    }

    /**
     * @param string $key
     * @return void
     */
    private function scheduleRevalidate(string $key): void
    {
        if (wp_next_scheduled(CronHooks::REVALIDATE_HOOK, [$key])) {
            return;
        }

        wp_schedule_single_event(time() + 5, CronHooks::REVALIDATE_HOOK, [$key]);
    }

    /**
     * @param string $key
     * @return void
     */
    public function revalidate(string $key): void
    {
        $cacheKey = self::CACHE_KEY_PREFIX . '_' . $key;
        $data = match ($key) {
            'casino_list' => $this->casinoApi->getCasinoListResponse(),
            default => str_starts_with($key, 'casino_')
                ? $this->casinoApi->getCasinoResponse((int) str_replace('casino_', '', $key))
                : null,
        };

        if ($data === null) {
            return;
        }

        set_transient($cacheKey, ['cached_at' => time(), 'data' => $data,], $this->cacheTtl);
    }
}
