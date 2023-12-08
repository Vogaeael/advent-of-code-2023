<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineTwoPair extends AbstractDetermineType
{
    protected const TYPE = CamelCards::TYPE_TWO_PAIR;

    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === 2 && $cards[1] === 2) {
            return true;
        }

        return false;
    }
}
