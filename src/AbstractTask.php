<?php

namespace Vogaeael\AdventOfCode2023;

abstract class AbstractTask implements TaskInterface
{
    protected const DAY = 0;
    protected const PART = 0;

    /**
     * @inheritDoc
     */
    abstract public function run(string $input): float;

    public function getDay(): int
    {
        return static::DAY;
    }

    public function getPart(): int
    {
        return static::PART;
    }

    /**
     * @param string $input
     *
     * @return string[]
     */
    protected function separateOnNewLine(string $input): array
    {
        return explode(PHP_EOL, $input);
    }

    /**
     * @return int[]
     */
    protected function getNumbersOfInput(string $input): array
    {
        $matches = [];
        preg_match_all('/-*\d+/', $input, $matches);

        return $matches[0];
    }

    /**
     * @param string[] $input
     *
     * @return int[]
     */
    protected function castStringArrayToIntArray(array $input): array
    {
        $numbers = [];
        foreach ($input as $stringNumber) {
            $numbers[] = (int) $stringNumber;
        }

        return $numbers;
    }
}
