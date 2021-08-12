<?php

namespace Ulv\Blockchain\Domain;

use Ulv\Blockchain\Adapter\StorageAdapterInterface;
use Ulv\Blockchain\Exception\InsufficientBalanceException;

/**
 * @package Ulv\Blockchain
 */
class State implements StateInterface
{
    /**
     * @var array
     */
    private $balances = [];

    /**
     * @var MempoolInterface
     */
    private $txMempool;

    /**
     * @var StorageAdapterInterface
     */
    private $storage;

    /**
     * @param StorageAdapterInterface $storage
     */
    public function __construct(StorageAdapterInterface $storage, MempoolInterface $mempool)
    {
        $this->storage = $storage;
        $this->txMempool = $mempool;

        $genesis = $this->storage->loadGenesis();
        foreach ($genesis as $customer => $balance) {
            $this->balances[$customer] = $balance;
        }

        $txDb = $this->storage->loadTxDb();
        foreach ($txDb as $serializedTx) {
            $this->add(Tx::fromArray($serializedTx));
        }
    }

    public function add(TxInterface $tx): void
    {
        $this->apply($tx);
        $this->txMempool->push($tx);
    }

    public function persist()
    {
        $this->storage->persist($this->txMempool);
    }

    public function getBalances(): array
    {
        return $this->balances;
    }

    private function apply(TxInterface $tx): void
    {
        if ($tx->isReward() && $tx->getFrom() === $tx->getTo()) {
            $this->balances[$tx->getTo()] += $tx->getValue();
        } elseif ($tx->getValue() > $this->balances[$tx->getFrom()]) {
            throw new InsufficientBalanceException($tx->getFrom() . ': insufficient balance');
        } else {
            $this->balances[$tx->getFrom()] -= $tx->getValue();
            $this->balances[$tx->getTo()]   += $tx->getValue();
        }
    }
}