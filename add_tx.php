<?php

require_once __DIR__ . '/vendor/autoload.php';

$cli = new League\CLImate\CLImate;
$cli->description('Add transaction to blockchain');

$cli->arguments->add([
    'from'  => [
        'prefix'      => 'f',
        'longPrefix'  => 'from',
        'description' => 'Transfer from',
        'required'    => true,
    ],
    'to'    => [
        'prefix'      => 't',
        'longPrefix'  => 'to',
        'description' => 'Transfer to',
        'required'    => true,
    ],
    'value' => [
        'prefix'      => 'v',
        'longPrefix'  => 'value',
        'description' => 'Value (amount)',
        'required'    => true,
        'castTo'      => 'int',
    ],
    'data'  => [
        'prefix'       => 'd',
        'longPrefix'   => 'data',
        'description'  => 'Data (accepts only values "" or "reward")',
        'defaultValue' => '',
    ],
]);

try {
    $cli->arguments->parse();
} catch (\League\CLImate\Exceptions\InvalidArgumentException $e) {
    $cli->usage();
    die(1);
}

$from  = $cli->arguments->get('from');
$to    = $cli->arguments->get('to');
$value = $cli->arguments->get('value');
$data  = $cli->arguments->get('data');

$storageAdapter = new \Ulv\Blockchain\Adapter\DiskStorageAdapter(__DIR__ . '/db/');
$mempool        = new \Ulv\Blockchain\Domain\Mempool();

$state = new \Ulv\Blockchain\Domain\State($storageAdapter, $mempool);
$tx    = new \Ulv\Blockchain\Domain\Tx($from, $to, $value, $data);
$state->add($tx);

$cli->green('TX Mempool');
$cli->table($state->getTxMempool()->toArray());

$cli->green('Balances');
$cli->table([$state->getBalances()]);

$state->persist();
