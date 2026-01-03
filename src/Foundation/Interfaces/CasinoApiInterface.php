<?php

namespace TestProject\CasinoCards\Foundation\Interfaces;

/**
 * CasinoApiInterface interface
 */
interface CasinoApiInterface
{
    /**
     * @param string $id
     * @return array
     */
    public function getCasinoResponse(string $id): array;

    /**
     * @return array
     */
    public function getCasinoListResponse(): array;
}
