<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineOnePair extends AbstractDetermineType
{
    protected const TYPE = CamelCards::TYPE_ONE_PAIR;

    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === 2 && $cards[1] === 1) {
            return true;
        }

        return false;
    }
}
