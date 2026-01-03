<?php

namespace TestProject\CasinoCards;

use TestProject\CasinoCards\Admin\AdminServiceProvider;
use TestProject\CasinoCards\ContentTypes\ContentTypesRegister;
use TestProject\CasinoCards\Foundation\Traits\Singleton;
use TestProject\CasinoCards\Gutenberg\GutenbergRegister;
use TestProject\CasinoCards\Hooks\CronHooks;
use TestProject\CasinoCards\RestApi\RestApiRegister;

/**
 * Class Bootstrap
 */
final class Bootstrap
{
    use Singleton;

    public static string $pluginPath;

    public static string $pluginUrl;

    /**
     *
     */
    private function __construct()
    {
        $pluginRoot = dirname(__FILE__);
        self::$pluginPath = plugin_dir_path($pluginRoot);
        self::$pluginUrl = plugin_dir_url($pluginRoot);

        if (is_admin()) {
            AdminServiceProvider::instance();
        }

        (new CronHooks())->register();
        (new GutenbergRegister())->register();
        (new RestApiRegister())->register();
        (new ContentTypesRegister())->register();
    }

    /**
     * @return void
     */
    public static function activate(): void
    {
        (new ContentTypesRegister())->registerAllNow();
        flush_rewrite_rules();
    }

    /**
     * * @return void
     */
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }
}
