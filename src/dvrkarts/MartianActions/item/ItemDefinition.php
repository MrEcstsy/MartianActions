<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\item;

final class ItemDefinition {

    public function __construct(
        private string $identifier,
        private array $data
    )
    {
    }

    public function getIdentifier(): string {
        return $this->identifier;
    }

    public function getData(): array {
        return $this->data;
    }
}