<?php

namespace TestProject\CasinoCards\Admin\Pages;

use TestProject\CasinoCards\Config\PluginConfig;

/**
 * SettingsPage class
 */
class SettingsPage
{
    /**
     * @return void
     */
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    /**
     * @return void
     */
    public function addMenu(): void
    {
        add_options_page(
            PluginConfig::SETTINGS_PAGE_TITLE,
            PluginConfig::SETTINGS_MENU_TITLE,
            PluginConfig::CAPABILITY,
            PluginConfig::SETTINGS_MENU_SLUG,
            [$this, 'renderPage']
        );
    }

    /**
     * @return void
     */
    public function registerSettings(): void
    {
        register_setting(
            PluginConfig::SETTINGS_MENU_SLUG,
            PluginConfig::OPTION_NAME,
            [
                'type' => 'array',
                'sanitize_callback' => [$this, 'sanitize'],
                'default' => [],
            ]
        );

        add_settings_section(
            'casino_cards_api_section',
            'Cartable API Credentials',
            '__return_null',
            PluginConfig::SETTINGS_MENU_SLUG
        );

        add_settings_field(
            PluginConfig::CARTABLE_API_USERNAME,
            'API Username',
            [$this, 'renderUsernameField'],
            PluginConfig::SETTINGS_MENU_SLUG,
            'casino_cards_api_section'
        );

        add_settings_field(
            PluginConfig::CARTABLE_API_PASSWORD,
            'API Password',
            [$this, 'renderPasswordField'],
            PluginConfig::SETTINGS_MENU_SLUG,
            'casino_cards_api_section'
        );
    }

    /**
     * @param mixed $value
     * @return array<string, string>
     */
    public function sanitize($value): array
    {
        $value = is_array($value) ? $value : [];
        $result = [];

        $result[PluginConfig::CARTABLE_API_USERNAME] = isset($value[PluginConfig::CARTABLE_API_USERNAME])
            ? sanitize_text_field(wp_unslash((string) $value[PluginConfig::CARTABLE_API_USERNAME]))
            : '';

        $newPassword = isset($value[PluginConfig::CARTABLE_API_PASSWORD])
            ? trim(wp_unslash((string) $value[PluginConfig::CARTABLE_API_PASSWORD]))
            : '';

        $result[PluginConfig::CARTABLE_API_PASSWORD] = $newPassword !== PluginConfig::PASSWORD_MASK
            ? $newPassword
            : PluginConfig::getOption(PluginConfig::CARTABLE_API_PASSWORD);

        return $result;
    }

    /**
     * @return void
     */
    public function renderPage(): void
    {
        if (! current_user_can(PluginConfig::CAPABILITY)) {
            return;
        }

        echo '<div class="wrap">';
        echo '<h1>' . esc_html(PluginConfig::SETTINGS_PAGE_TITLE) . '</h1>';
        echo '<form method="post" action="options.php">';

        settings_fields(PluginConfig::SETTINGS_MENU_SLUG);
        do_settings_sections(PluginConfig::SETTINGS_MENU_SLUG);
        submit_button();

        echo '</form>';
        echo '</div>';
    }

    /**
     * @return void
     */
    public function renderUsernameField(): void
    {
        $value = PluginConfig::getOption(PluginConfig::CARTABLE_API_USERNAME);

        printf(
            '<input type="text" name="%s[%s]" value="%s" class="regular-text" />',
            esc_attr(PluginConfig::OPTION_NAME),
            esc_attr(PluginConfig::CARTABLE_API_USERNAME),
            esc_attr($value)
        );
    }

    /**
     * @return void
     */
    public function renderPasswordField(): void
    {
        // hide password in rendered HTML
        $hasPassword = PluginConfig::getOption(PluginConfig::CARTABLE_API_PASSWORD) !== '';
        $value = $hasPassword ? PluginConfig::PASSWORD_MASK : '';

        printf(
            '<input type="password" name="%s[%s]" value="%s" class="regular-text" autocomplete="off" />',
            esc_attr(PluginConfig::OPTION_NAME),
            esc_attr(PluginConfig::CARTABLE_API_PASSWORD),
            esc_attr($value)
        );
    }
}
