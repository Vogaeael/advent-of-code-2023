<?php

namespace Vogaeael\AdventOfCode2023\day07\part02\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineThreeOfAKindWithJoker extends AbstractMostOfOneCardWithJoker
{
    protected const TYPE = CamelCards::TYPE_THREE_KIND;
    protected const NUMBER_OF_CARDS = 3;
}
