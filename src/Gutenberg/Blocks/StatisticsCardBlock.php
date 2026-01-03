<?php

namespace TestProject\CasinoCards\Gutenberg\Blocks;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use TestProject\CasinoCards\Api\Dto\Casino;
use TestProject\CasinoCards\Api\Factory\CasinoProviderFactory;
use TestProject\CasinoCards\Api\HttpClient;

/**
 * StatisticsCardBlock class
 */
class StatisticsCardBlock extends AbstractBlockRender
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
        $content = $this->renderTemplate('blocks/statistics-card.php', [
            'casino' => $data,
            'overrides' => $overrides
        ]);

        return "<div {$wrapperAttrs}>{$content}</div>";
    }

    /**
     * @param Casino $casino
     * @param array $overrides
     * @return Casino
     * @throws ReflectionException
     */
    private function applyOverrides(Casino $casino, array $overrides): Casino
    {
        $overridesValues = array_filter($overrides, function ($value): bool {
            return $value !== null && $value !== '';
        });

        $ref = new ReflectionClass(Casino::class);
        foreach ($overridesValues as $key => $override) {
            if (isset($casino->{$key})) {
                // check int|float types
                $type = $ref->getProperty($key)->getType();
                $typeName = $type instanceof ReflectionNamedType ? $type->getName() : null;
                if ($typeName === 'int' || $typeName === 'float') {
                    $val = str_replace(',', '.', trim((string) $override));
                    if (! is_numeric($val)) {
                        continue;
                    }
                    $casino->{$key} = ($typeName === 'int') ? (int) $val : (float) $val;
                    continue;
                }

                $casino->{$key} = $override;
            }
        }

        return $casino;
    }
}
