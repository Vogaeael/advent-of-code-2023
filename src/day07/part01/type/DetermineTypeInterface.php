<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

interface DetermineTypeInterface
{
    /**
     * @param array<string, int> $cards
     */
    public function isType(array $cards): bool;

    public function getTypeName(): string;
}
