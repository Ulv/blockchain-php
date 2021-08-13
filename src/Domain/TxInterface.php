<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain
 */
interface TxInterface
{
    public function serialize(): string;

    public function isReward(): bool;

    public function getFrom(): string;

    public function getTo(): string;

    public function getValue(): int;

    public function toArray(): array;
}