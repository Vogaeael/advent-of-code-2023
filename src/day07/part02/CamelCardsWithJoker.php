<?php

namespace Vogaeael\AdventOfCode2023\day07\part02;

use Exception;
use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class CamelCardsWithJoker extends CamelCards
{
    protected const PART = 2;

    protected const CARD_ORDER = [
        'A' => 0,
        'K' => 1,
        'Q' => 2,
        'T' => 3,
        '9' => 4,
        '8' => 5,
        '7' => 6,
        '6' => 7,
        '5' => 8,
        '4' => 9,
        '3' => 10,
        '2' => 11,
        'J' => 12
    ];

    public const JOKER = 'J';

    /**
     * @throws Exception
     */
    protected function determineType(string $hand): string
    {
        $howManyOfWhichCard = $this->howManyOfWhichCard($hand);
        $possibleTypes = [];
        foreach ($this->determineTypeCollection as $determineType) {
            if ($determineType->isType($howManyOfWhichCard)) {
                $possibleTypes[] = $determineType->getTypeName();
            }
        }

        usort($possibleTypes, [static::class, 'compareTypes']);

        return $possibleTypes[0];
    }

    static protected function compareTypes(string $first, string $second): int
    {
        return static::TYPE_ORDER[$first] <=> static::TYPE_ORDER[$second];
    }
}
