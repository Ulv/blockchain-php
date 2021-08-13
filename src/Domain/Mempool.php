<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain\Domain
 */
class Mempool extends \SplDoublyLinkedList implements MempoolInterface
{
    private $lastTxHash = '';

    private $lastPosition = 0;

    public function push($value)
    {
        if (empty($this->lastTxHash)) {
            $this->lastTxHash = str_repeat('0', 64);
        }

        $hash = $this->getHash($value);
        $value->setPosition(++$this->lastPosition);
        $value->setHash($hash);
        $value->setPrevHash($this->lastTxHash);

        parent::push($value);

        $this->lastTxHash = $hash;
    }

    public function toArray(): array
    {
        $result = [];

        /** @var TxInterface $item */
        foreach ($this as $item) {
            $result[] = $item->toArray();
        }

        return $result;
    }

    private function getHash(TxInterface $tx): string
    {
        return hash('sha256',
            implode('|', [
                (string)microtime(true),
                $tx->getFrom(),
                $tx->getTo(),
                $tx->getValue(),
                (int)$tx->isReward(),
            ]));
    }
}