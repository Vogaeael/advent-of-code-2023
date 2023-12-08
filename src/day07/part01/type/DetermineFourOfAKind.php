<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;
use Vogaeael\AdventOfCode2023\day07\part01\type\AbstractDetermineType;

class DetermineFourOfAKind extends AbstractDetermineType
{
    protected const TYPE = CamelCards::TYPE_FOUR_KIND;

    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === 4) {
            return true;
        }

        return false;
    }
}
