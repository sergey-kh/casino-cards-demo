<?php

namespace TestProject\CasinoCards\ContentTypes;

use TestProject\CasinoCards\Bootstrap;
use TestProject\CasinoCards\ContentTypes\PostTypes\CasinoPostType;

/**
 * ContentTypesRegister class
 */
final class ContentTypesRegister
{
    /**
     * @return void
     */
    public function register(): void
    {
        add_action('init', [$this, 'registerAll']);
        add_filter('template_include', [$this, 'getTemplate'], 20);
    }

    /**
     * @return void
     */
    public function registerAll(): void
    {
        (new CasinoPostType())->register();
    }

    /**
     * @return void
     */
    public function registerAllNow(): void
    {
        $this->registerAll();
    }

    /**
     * TODO: Implement class for all templates in plugin
     *
     * @param string $template
     * @return string
     */
    public function getTemplate(string $template): string
    {
        if (! is_singular(CasinoPostType::POST_TYPE)) {
            return $template;
        }

        // theme override (child/parent)
        $themeTemplate = locate_template([
            'casino-cards-demo/single-casino.php',
            'single-casino.php',
        ]);

        if ($themeTemplate) {
            return $themeTemplate;
        }

        // 2) plugin fallback
        $pluginTemplate = rtrim(Bootstrap::$pluginPath, '/') . '/templates/casino/single-casino.php';
        if (is_readable($pluginTemplate)) {
            return $pluginTemplate;
        }

        return $template;
    }
}
