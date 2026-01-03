<?php

namespace TestProject\CasinoCards\Gutenberg\Blocks;

use Exception;
use TestProject\CasinoCards\Api\Dto\Casino;
use TestProject\CasinoCards\Api\Factory\CasinoProviderFactory;
use TestProject\CasinoCards\Api\HttpClient;

/**
 * BonusCardBlock class
 */
class BonusCardBlock extends AbstractBlockRender
{
    /**
     * @param $attributes
     * @return string
     */
    protected function render($attributes): string
    {
        $data = '';
        $casinoId = isset($attributes['casinoId']) ? (string) $attributes['casinoId'] : '';
        if ($casinoId === '') {
            return $data;
        }

        try {
            $casinoFactory = new CasinoProviderFactory(new HttpClient());
            $provider = $casinoFactory->create('cartable');
            $casino = $provider->getCasino($casinoId);
            $overrides = [];
            if (isset($attributes['overrides']) && is_array($attributes['overrides'])) {
                $overrides = $attributes['overrides'];
            }
            $data = $this->applyOverrides($casino, $overrides);
        } catch (Exception $e) {
            // TODO: Handle Exceptions
            return $data;
        }

        $wrapperAttrs = get_block_wrapper_attributes();
        $content = $this->renderTemplate('blocks/bonus-card.php', [
            'casino' => $data,
            'overrides' => $overrides
        ]);

        return "<div {$wrapperAttrs}>{$content}</div>";
    }

    /**
     * @param Casino $casino
     * @param array $overrides
     * @return Casino
     */
    private function applyOverrides(Casino $casino, array $overrides): Casino
    {
        $overridesValues = array_filter($overrides, function ($value): bool {
            return $value !== null && $value !== '';
        });

        foreach ($overridesValues as $key => $override) {
            if (isset($casino->{$key})) {
                $casino->{$key} = $override;
            }
        }

        return $casino;
    }
}
