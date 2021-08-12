<?php

namespace Ulv\Blockchain\Adapter;

use Ulv\Blockchain\Domain\TxInterface;
use Ulv\Blockchain\Exception\InvalidGenesisException;
use Ulv\Blockchain\Exception\InvalidTxDbException;

/**
 * @package Ulv\Blockchain\Adapter
 */
class DiskStorageAdapter implements StorageAdapterInterface
{
    /**
     * @var string
     */
    private $dbPath;

    /**
     * @param string $dbPath
     */
    public function __construct(string $dbPath)
    {
        $this->dbPath = rtrim($dbPath, '/');
    }

    public function loadGenesis(): array
    {
        $genesis = \json_decode(file_get_contents($this->dbPath . '/genesis.json'), true, JSON_THROW_ON_ERROR);

        // @todo move to validator class
        if (!isset($genesis['balances']) || empty($genesis['balances'])) {
            throw new InvalidGenesisException('No "balances"');
        }

        return $genesis['balances'];
    }

    public function loadTxDb(): array
    {
        $result = [];
        $handle = fopen($this->dbPath . '/tx.db', 'rb');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $result[] = \json_decode($line, true, JSON_THROW_ON_ERROR);
            }
            fclose($handle);
        } else {
            throw new InvalidTxDbException('Can\'t open txDb!');
        }

        return $result;
    }

    public function persist(array $txMempool): void
    {
        $fp = fopen($this->dbPath . '/tx.db', 'wb+');
        if (flock($fp, LOCK_EX)) {
            /** @var TxInterface $tx */
            foreach ($txMempool as $tx) {
                fwrite($fp, $tx->serialize() . PHP_EOL);
            }
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
}