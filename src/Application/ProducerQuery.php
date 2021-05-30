<?php

namespace Application;

class ProducerQuery {
    public function __construct(
        private Interfaces\ProducerRepository $producerRepository
    ) { }

    public function execute(): array {
        $res = [];
        foreach ($this->producerRepository->getAllProducers() as $pr) {
            $res[] = new \Application\ProducerData($pr->getProducerId(), $pr->getName());
        }
        return $res;
    }
}