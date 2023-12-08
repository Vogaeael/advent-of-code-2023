<?php

namespace Vogaeael\AdventOfCode2023\day07\part02\type;

use Vogaeael\AdventOfCode2023\day07\part01\type\DetermineTwoPair;
use Vogaeael\AdventOfCode2023\day07\part02\CamelCardsWithJoker;

class DetermineTwoPairWithJoker extends DetermineTwoPair
{
    /**
     * @inheritDoc
     */
    public function isType(array $cards): bool
    {
        $advancedCards = $this->cardsArrayToAdvancedCards($cards);
        $advancedCards = $this->sortAdvancedCardsJokerFirst($advancedCards);

        if (CamelCardsWithJoker::JOKER === $advancedCards[0]['card']) {
            /**
             * When you have one or more joker and you could create two pair with it, you could also create 3 of a kind or better things.
             * Also I don't want to blow this code up tooo much
             * (I'm already doing it)
             */
            return false;
        }

        return parent::isType($cards);
    }
}
