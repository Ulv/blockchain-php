<?php

require_once __DIR__.'/vendor/autoload.php';

$adapter = new \Ulv\Blockchain\Adapter\DiskStorageAdapter(__DIR__.'/db/');

$state = new \Ulv\Blockchain\Domain\State($adapter);

$tx = new \Ulv\Blockchain\Domain\Tx('vova', 'someone', 100);
$state->add($tx);

$tx = new \Ulv\Blockchain\Domain\Tx('someone', 'vova', 10);
$state->add($tx);

var_dump($state->getBalances());

//$state->persist();