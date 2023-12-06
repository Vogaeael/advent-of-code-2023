<?php

namespace Vogaeael\AdventOfCode2023\day03\part02;

use Vogaeael\AdventOfCode2023\day03\part01\EngineNumberWithAdjacentSymbols;

class EngineAsteriskWithTwoAdjacentNumbers extends EngineNumberWithAdjacentSymbols
{
    protected const DAY = 3;
    protected const PART = 2;

    protected const REGEX_ASTERISK = '/\*/';

    /** @var array<int, array<int, array{startPosition: int, value: string}>> */
    protected array $advancedNumbers = [];

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $input = $this->separateOnNewLine($input);
        $total = 0;

        foreach ($input as $lineNumber => $line) {
            $this->numbers[$lineNumber] = $this->getMatchesOfLine($line, self::REGEX_NUMBER);
            $this->symbols[$lineNumber] = $this->getMatchesOfLine($line, self::REGEX_ASTERISK);
        }
        $this->calculateAdvancedNumbers();

        foreach ($this->symbols as $lineNumber => $asterisks) {
            foreach (array_keys($asterisks) as $position) {
                $adjacent = $this->getAdjacentNumbers($lineNumber, $position);

                if (2 === count($adjacent)) {
                    $total += ($adjacent[0] * $adjacent[1]);
                }
            }
        }

        return $total;
    }

    protected function calculateAdvancedNumbers(): void
    {
        foreach ($this->numbers as $lineNumber => $numberWrapper) {
            $this->advancedNumbers[$lineNumber] = [];
            foreach ($numberWrapper as $position => $value) {
                $length = strlen($value);
                for ($i = 0; $i < $length; $i++) {
                    $this->advancedNumbers[$lineNumber][$position + $i] = [
                        'startPosition' => $position,
                        'value' => $value
                    ];
                }
            }
        }
    }

    /**
     * @return int[]
     */
    protected function getAdjacentNumbers(int $lineNumber, int $rowNumber): array
    {
        $numbers = $this->findAdjacentNumbers($lineNumber, $rowNumber);

        return $this->getValuesOfSurroundingNumbers($numbers);
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function findAdjacentNumbers(int $lineNumber, int $rowNumber): array
    {
        $surroundingNumbers = [];
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber - 1, $rowNumber - 1);
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber - 1, $rowNumber);
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber - 1, $rowNumber + 1);
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber, $rowNumber - 1);
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber, $rowNumber + 1);
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber + 1, $rowNumber - 1);
        $surroundingNumbers = $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber + 1, $rowNumber);

        return $this->addToSurroundingNumbersIfNumber($surroundingNumbers, $lineNumber + 1, $rowNumber + 1);
    }

    /**
     * @param array<int, array<int, string>> $surroundingNumbers
     *
     * @return array<int, array<int, string>>
     */
    protected function addToSurroundingNumbersIfNumber(array $surroundingNumbers, int $lineNumber, int $rowNumber): array
    {
        $number = $this->getNumberOnPosition($lineNumber, $rowNumber);
        if ($number) {
            $surroundingNumbers[$lineNumber][$number['startPosition']] = $number['value'];
        }

        return $surroundingNumbers;
    }

    /**
     * @return array{startPosition: int, value: string}|null
     */
    protected function getNumberOnPosition(int $lineNumber, int $rowNumber): ?array
    {
        if (!array_key_exists($lineNumber, $this->advancedNumbers)) {
            return null;
        }
        $advancedNumbersLine = $this->advancedNumbers[$lineNumber];
        if (!array_key_exists($rowNumber, $advancedNumbersLine)) {
            return null;
        }

        return $advancedNumbersLine[$rowNumber];
    }

    /**
     * @param array<int, array<int, string>> $numbers
     *
     * @return int[]
     */
    protected function getValuesOfSurroundingNumbers(array $numbers): array
    {
        $values = [];

        foreach($numbers as $numberWrapper) {
            foreach($numberWrapper as $value) {
                $values[] = $value;
            }
        }

        return $values;
    }
}
