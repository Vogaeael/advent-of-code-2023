<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineHighCard extends AbstractMostOfOneCard
{
    protected const TYPE = CamelCards::TYPE_HIGH_CARD;
    protected const NUMBER_OF_CARDS = 1;
}
