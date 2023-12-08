<?php

namespace Vogaeael\AdventOfCode2023\day07\part02\type;

use Vogaeael\AdventOfCode2023\day07\part01\CamelCards;

class DetermineHighCardWithJoker extends AbstractMostOfOneCardWithJoker
{
    protected const TYPE = CamelCards::TYPE_HIGH_CARD;
    protected const NUMBER_OF_CARDS = 1;
}
