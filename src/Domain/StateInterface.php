<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain
 */
interface StateInterface
{
    public function add(TxInterface $tx): void;

    public function persist();

    public function getBalances(): array;
}