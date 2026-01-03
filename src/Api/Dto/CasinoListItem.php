<?php

namespace TestProject\CasinoCards\Api\Dto;

/**
 * CasinoListItem class
 */
class CasinoListItem
{
    public string $id;
    public string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
