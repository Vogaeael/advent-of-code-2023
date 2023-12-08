<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineHighCard extends AbstractDetermineType
{
    protected const TYPE = CamelCards::TYPE_HIGH_CARD;

    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === 1) {
            return true;
        }

        return false;
    }
}
