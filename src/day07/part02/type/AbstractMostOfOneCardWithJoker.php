<?php

namespace Vogaeael\AdventOfCode2023\day07\part02\type;

use Vogaeael\AdventOfCode2023\day07\part01\type\AbstractMostOfOneCard;
use Vogaeael\AdventOfCode2023\day07\part02\CamelCardsWithJoker;

class AbstractMostOfOneCardWithJoker extends AbstractMostOfOneCard
{
    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        $advancedCards = $this->cardsArrayToAdvancedCards($cards);
        $advancedCards = $this->sortAdvancedCardsJokerFirst($advancedCards);

        if (CamelCardsWithJoker::JOKER === $advancedCards[0]['card']) {
            $highestNotJokerCardNumber = 0;
            if (array_key_exists(1, $advancedCards)) {
                $highestNotJokerCardNumber = $advancedCards[1]['number'];
            }

            if (static::NUMBER_OF_CARDS <= $advancedCards[0]['number'] + $highestNotJokerCardNumber) {
                return true;
            }
        }

        if (static::NUMBER_OF_CARDS === $advancedCards[0]['number']) {
            return true;
        }

        return false;
    }
}
