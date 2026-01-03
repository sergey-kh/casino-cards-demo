<?php

namespace TestProject\CasinoCards\Foundation\Interfaces;

use TestProject\CasinoCards\Api\Dto\Casino;
use TestProject\CasinoCards\Api\Dto\CasinoListItem;

/**
 * CasinoProviderInterface interface
 */
interface CasinoProviderInterface
{
    /**
     * @param string $id
     * @return Casino
     */
    public function getCasino(string $id): Casino;

    /**
     * @return CasinoListItem[]
     */
    public function getCasinoList(): array;
}
