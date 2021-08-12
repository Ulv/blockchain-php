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
     * @param string $from
     * @param string $to
     * @param int              $value
     * @param string           $data
     */
    public function __construct(string $from,string $to, int $value, string $data = '')
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

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function serialize(): string
    {
        return \json_encode([
            'from'  => $this->from,
            'to'    => $this->to,
            'value' => $this->value,
            'data'  => $this->data,
        ], JSON_THROW_ON_ERROR);
    }
}