<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

abstract class AbstractDetermineType implements DetermineTypeInterface
{
    protected const TYPE = 'undefined';

    /**
     * @inheritDoc
     */
    abstract public function isType(array $cards): bool;

    public function getTypeName(): string
    {
        return static::TYPE;
    }
}
