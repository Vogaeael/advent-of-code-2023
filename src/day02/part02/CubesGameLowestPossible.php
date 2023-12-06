<?php

namespace Vogaeael\AdventOfCode2023\day02\part02;

use Vogaeael\AdventOfCode2023\AbstractTask;

class CubesGameLowestPossible extends AbstractTask
{
    protected const DAY = 2;
    protected const PART = 2;

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $lines = $this->separateOnNewLine($input);

        $total = 0;
        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }
            $body = $this->getBody($line);
            $gameNumber = $this->calculateNumberOfGame($body);

            $total += $gameNumber;
        }

        return $total;
    }

    protected function getBody(string $line): string
    {
        $parts = explode(': ', $line);

        return $parts[1];
    }

    /**
     * @param string $body
     *
     * @return string[]
     */
    protected function getRounds(string $body): array
    {
        return explode('; ', trim($body));
    }

    protected function calculateNumberOfGame(string $body): int
    {
        $rounds = $this->getRounds($body);
        $highestNumberOfColor = [];
        foreach ($rounds as $round) {
            $highestNumberOfColor = $this->getRoundColorNumbers($round, $highestNumberOfColor);
        }

        $total = 1;
        foreach ($highestNumberOfColor as $number) {
            $total *= $number;
        }

        return $total;
    }

    /**
     * @param array<string, int> $highestNumberOfColor
     *
     * @return array<string, int>
     */
    protected function getRoundColorNumbers(string $round, array $highestNumberOfColor): array
    {
        $colorValues = explode(', ', trim($round));
        foreach ($colorValues as $colorValue) {
            $values = explode(' ', $colorValue);
            $number = (int)$values[0];
            $color = $values[1];
            if (!array_key_exists($color, $highestNumberOfColor) || $number > $highestNumberOfColor[$color]) {
                $highestNumberOfColor[$color] = $number;
            }
        }

        return $highestNumberOfColor;
    }
}
