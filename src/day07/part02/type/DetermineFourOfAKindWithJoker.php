<?php

namespace Vogaeael\AdventOfCode2023\day07\part02\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineFourOfAKindWithJoker extends AbstractMostOfOneCardWithJoker
{
    protected const TYPE = CamelCards::TYPE_FOUR_KIND;
    protected const NUMBER_OF_CARDS = 4;
}
