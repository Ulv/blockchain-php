<?php

require_once __DIR__.'/vendor/autoload.php';

$storageAdapter = new \Ulv\Blockchain\Adapter\DiskStorageAdapter(__DIR__.'/db/');
$mempool = new \Ulv\Blockchain\Domain\Mempool();

$state = new \Ulv\Blockchain\Domain\State($storageAdapter, $mempool);

$tx = new \Ulv\Blockchain\Domain\Tx('vova', 'someone', 100);
$state->add($tx);

$tx = new \Ulv\Blockchain\Domain\Tx('someone', 'vova', 10);
$state->add($tx);

//var_dump($state->getBalances());

$state->persist();