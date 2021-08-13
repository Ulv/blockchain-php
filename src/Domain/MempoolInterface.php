<?php

namespace Ulv\Blockchain\Domain;

/**
 * @package Ulv\Blockchain\Domain
 */
interface MempoolInterface
{
    public function toArray(): array;
}