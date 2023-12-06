<?php

namespace Vogaeael\AdventOfCode2023\day02\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class CubesGame extends AbstractTask
{
    protected const DAY = 2;
    protected const PART = 1;
    protected array $possible;

    /**
     * @param array{red: int, blue: int, green: int} $possible
     */
    public function __construct(array $possible)
    {
        $this->possible = $possible;
    }

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
            $gameId = $this->getGameId($line);
            $body = $this->getBody($line);
            $gamePossible = $this->checkRoundsOfGame($body);

            if ($gamePossible) {
                $total += $gameId;
            }
        }

        return $total;
    }

    protected function getGameId(string $line): int
    {
        $matches = [];
        preg_match('/Game (\d+): /', $line, $matches);

        return (int)$matches[1];
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

    protected function checkRoundsOfGame(string $body): bool
    {
        $rounds = $this->getRounds($body);
        foreach ($rounds as $round) {
            $gamePossible = $this->checkRound($round);
            if (!$gamePossible) {
                return false;
            }
        }

        return true;
    }

    protected function checkRound(string $round): bool
    {
        $colorValues = explode(', ', trim($round));
        foreach ($colorValues as $colorValue) {
            $gamePossible = $this->checkColorValue($colorValue);
            if (!$gamePossible) {
                return false;
            }
        }

        return true;
    }

    protected function checkColorValue(string $colorValue): bool
    {
        $values = explode(' ', $colorValue);
        $number = (int)$values[0];
        $color = $values[1];

        return $number <= $this->possible[$color];
    }
}
