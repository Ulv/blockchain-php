<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain\Domain
 */
interface MempoolInterface
{
    public function push($value);

    public function toArray(): array;
}