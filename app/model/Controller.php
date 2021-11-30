<?php

abstract class Controller
{
    abstract function getKeys(): array;

    abstract function getId(): string;

    abstract function getTitle(): string;

    abstract function handle(array $args): void;

    abstract function render(): string;

    protected function encode_query(array $values): string
    {
        $queries = array_merge($values, ['controller' => $this->getId()]);
        return '?' . http_build_query($queries);
    }
}
