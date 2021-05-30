<?php

namespace Application\Entities;

class Producer {
    public function __construct (
        private int $producerId,
        private string $name
    ) { }

    /**
     * @return int
     */
    public function getProducerId(): int
    {
        return $this->producerId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}