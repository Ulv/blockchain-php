<?php

namespace Ulv\Blockchain\Adapter;

use Ulv\Blockchain\Domain\MempoolInterface;

/**
 * @package Ulv\Blockchain\Adapter
 */
interface StorageAdapterInterface
{
    public function loadGenesis(): array;
    public function loadTxDb(): array;
    public function persist(MempoolInterface $txMempool): void;
}