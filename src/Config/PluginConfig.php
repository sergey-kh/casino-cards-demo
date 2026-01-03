<?php

declare(strict_types=1);

namespace TestProject\CasinoCards\Config;

/**
 * PluginConfig class
 */
final class PluginConfig
{
    public const HOOKS_PREFIX = 'casino_cards_demo_';
    public const TEXT_DOMAIN = 'casino-cards-demo';

    public const CAPABILITY = 'manage_options';

    public const SETTINGS_MENU_SLUG = 'casino-cards-settings';
    public const SETTINGS_PAGE_TITLE = 'Casino Cards Settings';
    public const SETTINGS_MENU_TITLE = 'Casino Cards';

    public const OPTION_NAME = 'tp_casino_cards_settings';

    public const CARTABLE_API_USERNAME = 'cartable_api_username';
    public const CARTABLE_API_PASSWORD = 'cartable_api_password';

    public const PASSWORD_MASK = '**********';

    private static ?array $options = null;

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function getOption(string $key, string $default = ''): string
    {
        if (self::$options === null) {
            $loaded = get_option(self::OPTION_NAME, []);
            self::$options = is_array($loaded) ? $loaded : [];
        }

        return (string) (self::$options[$key] ?? $default);
    }
}
