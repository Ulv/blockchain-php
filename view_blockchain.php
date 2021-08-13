<?php

require_once __DIR__ . '/vendor/autoload.php';

$cli = new League\CLImate\CLImate;
$cli->description('View TX mempool');

$storageAdapter = new \Ulv\Blockchain\Adapter\DiskStorageAdapter(__DIR__ . '/db/');
$mempool        = new \Ulv\Blockchain\Domain\Mempool();

$state = new \Ulv\Blockchain\Domain\State($storageAdapter, $mempool);

$cli->green('TX Mempool');
$cli->table($state->getTxMempool()->toArray());

$cli->green('Balances');
$cli->table([$state->getBalances()]);

$state->persist();
