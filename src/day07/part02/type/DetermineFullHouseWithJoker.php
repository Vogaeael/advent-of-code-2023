<?php

namespace Vogaeael\AdventOfCode2023\day07\part02\type;

use Vogaeael\AdventOfCode2023\day07\part01\type\DetermineFullHouse;
use Vogaeael\AdventOfCode2023\day07\part02\CamelCardsWithJoker;

class DetermineFullHouseWithJoker extends DetermineFullHouse
{
    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        $advancedCards = $this->cardsArrayToAdvancedCards($cards);
        $advancedCards = $this->sortAdvancedCardsJokerFirst($advancedCards);

        if (CamelCardsWithJoker::JOKER === $advancedCards[0]['card']) {
            $numberJoker = $advancedCards[0]['number'];
            if ($numberJoker > 1) {
                /**
                 * When you have more then one joker and you could create a full house with it, you could also create 4 of a kind or better things.
                 * Also I don't want to blow this code up tooo much
                 * (I'm already doing it)
                 */
                return false;
            }
            if (array_key_exists(1, $advancedCards) && array_key_exists(2, $advancedCards)) {
                if (3 === $advancedCards[1]['number'] && $advancedCards[2]['number'] === 1) {
                    return true;
                }
                if (2 === $advancedCards[1]['number'] && 2 === $advancedCards[2]['number']) {
                    return true;
                }
            }
        }

        return parent::isType($cards);
    }
}
