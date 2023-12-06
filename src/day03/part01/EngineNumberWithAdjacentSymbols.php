<?php

namespace Vogaeael\AdventOfCode2023\day03\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class EngineNumberWithAdjacentSymbols extends AbstractTask
{
    protected const DAY = 3;
    protected const PART = 1;
    protected const REGEX_NUMBER = '/\d+/';
    protected const REGEX_SYMBOL = '/[^\d.]/';  //'/[=-#*+@&%$/]/';

    /** @var array<int, array<int, string>> $numbers */
    protected array $numbers = [];
    /** @var array<int, array<int, string>> $symbols */
    protected array $symbols = [];

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $input = $this->separateOnNewLine($input);
        $total = 0;

        foreach($input as $lineNumber => $line) {
            $this->numbers[$lineNumber] = $this->getMatchesOfLine($line, self::REGEX_NUMBER);
            $this->symbols[$lineNumber] = $this->getMatchesOfLine($line, self::REGEX_SYMBOL);
        }

        foreach ($this->numbers as $lineNumber => $numbers) {
            foreach($numbers as $position => $numberString) {
                if ($this->hasAdjacent($lineNumber, $position, $numberString)) {
                    $total += (int)$numberString;
                }
            }
        }

        return $total;
    }

    /**
     * @return array<int, string>
     */
    protected function getMatchesOfLine(string $line, string $regex): array
    {
        $result = [];
        $matches = [];
        preg_match_all($regex, $line, $matches, PREG_OFFSET_CAPTURE);
        foreach($matches[0] as $match) {
            $result[$match[1]] = $match[0];
        }

        return $result;
    }

    protected function hasAdjacent(int $lineNumber, int $position, string $numberString): bool
    {
        $numberPositions = $this->getNumberPositions($numberString, $position);

        foreach ($numberPositions as $numberPosition) {
            if ($this->hasSymbolAbove($lineNumber, $numberPosition)) {
                return true;
            }
            if ($this->hasSymbolBelow($lineNumber, $numberPosition)) {
                return true;
            }
        }

        $lastPosition = end($numberPositions);
        if ($this->hasSymbolInHoleRightSide($lineNumber, $lastPosition)) {
            return true;
        }

        $firstPosition = array_shift($numberPositions);
        if ($this->hasSymbolInHoleLeftSide($lineNumber, $firstPosition)) {
            return true;
        }

        return false;
    }

    /**
     * @return int[]
     */
    protected function getNumberPositions(string $numberString, int $numberFirstPosition): array
    {
        $numberPositions = [];
        $numberLength = strlen($numberString);
        for ($i = 0; $i < $numberLength; $i++) {
            $numberPositions[] = $numberFirstPosition + $i;
        }

        return $numberPositions;
    }

    protected function hasSymbolInHoleLeftSide(int $lineNumber, int $rowNumber): bool
    {
        return $this->hasSymbolInPositionAboveOrBelow($lineNumber, $rowNumber - 1);
    }

    protected function hasSymbolInHoleRightSide(int $lineNumber, int $rowNumber): bool
    {
        return $this->hasSymbolInPositionAboveOrBelow($lineNumber, $rowNumber + 1);
    }

    protected function hasSymbolInPositionAboveOrBelow(int $lineNumber, int $rowNumber): bool
    {
        if ($this->hasSymbolAbove($lineNumber, $rowNumber)) {
            return true;
        }
        if ($this->hasSymbolInPosition($lineNumber, $rowNumber)) {
            return true;
        }
        if ($this->hasSymbolBelow($lineNumber, $rowNumber)) {
            return true;
        }

        return false;
    }

    protected function hasSymbolAbove(int $lineNumber, int $rowNumber): bool
    {
        return $this->hasSymbolInPosition($lineNumber - 1, $rowNumber);
    }

    protected function hasSymbolBelow(int $lineNumber, int $rowNumber): bool
    {
        return $this->hasSymbolInPosition($lineNumber + 1, $rowNumber);
    }

    protected function hasSymbolInPosition(int $lineNumber, int $rowNumber): bool
    {
        if (array_key_exists($lineNumber, $this->symbols)) {
            $symbolsInLineAbove = $this->symbols[$lineNumber];

            if (array_key_exists($rowNumber, $symbolsInLineAbove)) {
                return true;
            }
        }

        return false;
    }
}
