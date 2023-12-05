<?php

namespace Vogaeael\AdventOfCode2023\day01\part02;

use Exception;
use Vogaeael\AdventOfCode2023\day01\part01\TrebuchetCalibration;

class AdvancedTrebuchetCalibration extends TrebuchetCalibration
{
    protected const PART = 2;

    protected const DIGITS = [
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9
    ];

    /**
     * @throws Exception
     */
    protected function getFirstDigit(string $input, ?array $digits = self::DIGITS): int
    {
        $possibleDigits = [];

        foreach ($digits as $key => $value) {
            $result = strpos($input, $key);
            if (false !== $result) {
                $possibleDigits[$result] = $key;
            }
        }
        ksort($possibleDigits);
        $possibleDigits = array_values($possibleDigits);
        if (0 === count($possibleDigits)) {
            return 0;
        }

        return $digits[$possibleDigits[0]];
    }

    /**
     * @throws Exception
     */
    protected function getLastDigit(string $input): int
    {
        $preparedDigits = [];
        foreach (self::DIGITS as $key => $digit) {
            $preparedDigits[strrev($key)] = $digit;
        }

        return $this->getFirstDigit(strrev($input), $preparedDigits);
    }
}
