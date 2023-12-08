<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineFiveOfAKind extends AbstractDetermineType
{
    protected const TYPE = CamelCards::TYPE_FIVE_KIND;

    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        rsort($cards);
        if ($cards[0] === 5) {
            return true;
        }

        return false;
    }
}
