<?php

namespace TestProject\CasinoCards\Admin;

use TestProject\CasinoCards\Admin\Pages\SettingsPage;
use TestProject\CasinoCards\Foundation\Traits\Singleton;

/**
 * AdminServiceProvider class
 */
final class AdminServiceProvider
{
    use Singleton;

    private function __construct()
    {
        (new SettingsPage())->register();
    }
}
