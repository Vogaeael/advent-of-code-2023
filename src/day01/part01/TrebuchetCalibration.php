<?php

namespace Vogaeael\AdventOfCode2023\day01\part01;

use IntlChar;
use Vogaeael\AdventOfCode2023\AbstractTask;

class TrebuchetCalibration extends AbstractTask
{
    protected const DAY = 1;
    protected const PART = 1;

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $input = $this->separateOnNewLine($input);

        $total = 0;
        foreach ($input as $line) {
            $firstDigit = $this->getFirstDigit($line);
            $lastDigit = $this->getLastDigit($line);

            $number = $firstDigit * 10 + $lastDigit;
            $total += $number;
        }

        return $total;
    }

    private function getFirstDigit(string $input): int
    {
        $chars = str_split($input);
        foreach ($chars as $char) {
            if (IntlChar::isdigit($char)) {
                return (int) $char;
            }
        }

        return 0;
    }

    private function getLastDigit(string $input): int
    {
        return $this->getFirstDigit(strrev($input));
    }
}
