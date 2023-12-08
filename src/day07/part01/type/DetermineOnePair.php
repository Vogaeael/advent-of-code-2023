<?php

namespace Vogaeael\AdventOfCode2023\day07\part01\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineOnePair extends AbstractMostOfOneCard
{
    protected const TYPE = CamelCards::TYPE_ONE_PAIR;
    protected const NUMBER_OF_CARDS = 2;
}
