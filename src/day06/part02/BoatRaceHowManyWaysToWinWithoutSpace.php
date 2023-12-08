<?php

namespace Vogaeael\AdventOfCode2023\day06\part02;

use Vogaeael\AdventOfCode2023\day06\part01\BoatRaceHowManyWaysToWin;

class BoatRaceHowManyWaysToWinWithoutSpace extends BoatRaceHowManyWaysToWin
{
    protected const PART = 2;

    protected function determineRaces(string $input): void
    {
        $input = $this->separateOnNewLine($input);
        $timeLimit = $this->getNumberWithoutSpacesAndTitle($input[0]);
        $bestRecord = $this->getNumberWithoutSpacesAndTitle($input[1]);

        $this->races[] = [
            'timeLimit' => $timeLimit,
            'bestRecord' => $bestRecord
        ];
    }

    protected function getNumberWithoutSpacesAndTitle(string $input): int
    {
        $parts = explode(':', $input);
        $body = $parts[1];
        $body = str_replace(' ', '', $body);

        return $this->getNumbersOfInput($body)[0];
    }
}
