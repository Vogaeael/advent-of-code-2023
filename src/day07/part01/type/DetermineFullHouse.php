<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineFullHouse extends AbstractDetermineType
{
    protected const TYPE = CamelCards::TYPE_FULL_HOUSE;

    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === 3 && $cards[1] === 2) {
            return true;
        }

        return false;
    }
}
