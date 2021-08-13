<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain
 */
class Tx implements TxInterface
{
    public const REWARD = 'reward';

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var int
     */
    private $value = 0;

    /**
     * @var string
     */
    private $data = self::REWARD;

    /**
     * @var string
     */
    private $hash = '';

    /**
     * @var string
     */
    private $prevHash = '';

    /**
     * @var int
     */
    private $position = 1;

    /**
     * @param string $from
     * @param string $to
     * @param int    $value
     * @param string $data
     */
    public function __construct(string $from, string $to, int $value, string $data = '')
    {
        $this->from  = $from;
        $this->to    = $to;
        $this->value = $value;
        $this->data  = $data;
    }

    public static function fromArray(array $data): self
    {
        // @todo validate input
        return new static($data['from'], $data['to'], $data['value'], $data['data']);
    }

    public function isReward(): bool
    {
        return $this->data === self::REWARD;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setHash(string $hash): Tx
    {
        $this->hash = $hash;
        return $this;
    }

    public function setPrevHash(string $prevHash): Tx
    {
        $this->prevHash = $prevHash;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): Tx
    {
        $this->position = $position;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'position'  => $this->position,
            'from'      => $this->from,
            'to'        => $this->to,
            'value'     => $this->value,
            'data'      => $this->data,
            'hash'      => $this->hash,
            'prev_hash' => $this->prevHash,
        ];
    }

    public function serialize(): string
    {
        return \json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}