<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

class AbstractMostOfOneCard extends AbstractDetermineType
{
    protected const NUMBER_OF_CARDS = 0;

    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === static::NUMBER_OF_CARDS && $cards[1] <= 1) {
            return true;
        }

        return false;
    }
}
