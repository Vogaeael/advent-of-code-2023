<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part02\CamelCardsWithJoker;

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
    /**
     * @param array<string, int> $cards
     *
     * @return array<int, array{card: string, number: int}>
     */
    protected function cardsArrayToAdvancedCards(array $cards): array
    {
        $result = [];
        foreach($cards as $card => $number) {
            $result[] = [
                'card' => $card,
                'number' => $number
            ];
        }

        return $result;
    }

    protected function sortAdvancedCardsJokerFirst(array $cards): array
    {
        usort($cards, [static::class, 'compareCardsNumber']);

        return $cards;
    }

    static protected function compareCardsNumber(array $first, array $second): int
    {
        if (CamelCardsWithJoker::JOKER === $first['card']) {
            return -1;
        }
        if (CamelCardsWithJoker::JOKER === $second['card']) {
            return 1;
        }
        return $second['number'] <=> $first['number'];
    }
}
