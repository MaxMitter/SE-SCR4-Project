<?php

namespace Application;

class ProducerData {
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