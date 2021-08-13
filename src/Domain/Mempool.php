<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain\Domain
 */
class Mempool extends \SplDoublyLinkedList implements MempoolInterface
{
    public function toArray(): array
    {
        $result = [];

        /** @var TxInterface $item */
        foreach ($this as $item) {
            $result[] = $item->toArray();
        }

        return $result;
    }
}