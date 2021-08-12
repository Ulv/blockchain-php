<?php

namespace Ulv\Blockchain\Adapter;

/**
 * @package Ulv\Blockchain\Adapter
 */
interface StorageAdapterInterface
{
    public function loadGenesis(): array;
    public function loadTxDb(): array;
    public function persist(array $txMempool): void;
}