<?php

namespace Vogaeael\AdventOfCode2023\day10\part01;

use Exception;
use Vogaeael\AdventOfCode2023\AbstractTask;

class FarthestInPipe extends AbstractTask
{
    protected const DAY = 10;
    protected const PART = 1;

    protected const NORTH = 'north';
    protected const EAST = 'east';
    protected const SOUTH = 'south';
    protected const WEST = 'west';

    protected const POSSIBLE_PIPES = [
        '.' => [],
        'S' => [],
        '|' => [self::NORTH, self::SOUTH],
        '-' => [self::WEST, self::EAST],
        'L' => [self::NORTH, self::EAST],
        'J' => [self::NORTH, self::WEST],
        '7' => [self::WEST, self::SOUTH],
        'F' => [self::EAST, self::SOUTH]
    ];

    /** @var array<int, array<int, string[]>> $map */
    protected array $map = [];
    /** @var array<int,array{x: int, y: int}> */
    protected array $mainLoopPipe = [];
    /** @var array{x: int, y: int} $startCoordinate */
    protected array $startCoordinate;

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $this->insertInputIntoMap($input);
        $this->defineDirectionsOfStart();
        $this->determineMainLoop();

        return count($this->mainLoopPipe) / 2;
    }

    protected function insertInputIntoMap(string $input): void
    {
        $input = $this->separateOnNewLine($input);
        foreach ($input as $yCoordinate => $line) {
            if (empty($line)) {
                continue;
            }
            foreach (str_split($line) as $xCoordinate => $symbol) {
                if ($this->isStartSymbol($symbol)) {
                    $this->startCoordinate = [
                        'x' => $xCoordinate,
                        'y' => $yCoordinate
                    ];
                }

                $this->map[$yCoordinate][$xCoordinate] = static::POSSIBLE_PIPES[$symbol];
            }
        }
    }

    protected function isStartSymbol(string $symbol): bool
    {
        return 'S' === $symbol;
    }

    protected function defineDirectionsOfStart(): void
    {
        $startY = $this->startCoordinate['y'];
        $startX = $this->startCoordinate['x'];

        if ($this->doesFieldShowInDirection($startY - 1, $startX, self::SOUTH)) {
            $this->map[$startY][$startX][] = self::NORTH;
        }

        if ($this->doesFieldShowInDirection($startY + 1, $startX, self::NORTH)) {
            $this->map[$startY][$startX][] = self::SOUTH;
        }

        if ($this->doesFieldShowInDirection($startY, $startX - 1, self::EAST)) {
            $this->map[$startY][$startX][] = self::WEST;
        }

        if ($this->doesFieldShowInDirection($startY, $startX + 1, self::WEST)) {
            $this->map[$startY][$startX][] = self::EAST;
        }
    }

    protected function doesFieldShowInDirection(int $yCoordinate, int $xCoordinate, string $direction): bool
    {
        if (array_key_exists($yCoordinate, $this->map)) {
            $lineAbove = $this->map[$yCoordinate];
            if (array_key_exists($xCoordinate, $lineAbove)) {
                $field = $lineAbove[$xCoordinate];

                return in_array($direction, $field);
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    protected function determineMainLoop(): void
    {
        $currentCoordinate = $this->startCoordinate;
        $lastDirection = $this->map[$currentCoordinate['y']][$currentCoordinate['x']][0];
        do {
            $this->mainLoopPipe[] = $currentCoordinate;
            $currentCoordinate = $this->getNextCoordinate($currentCoordinate, $lastDirection);
            $lastDirection = $this->getNextDirection($this->map[$currentCoordinate['y']][$currentCoordinate['x']], $lastDirection);
        } while (!$this->isStartCoordinate($currentCoordinate));
    }

    /**
     * @param array{y: int, x: int} $coordinate
     *
     * @return array{y: int, x: int}
     */
    protected function getNextCoordinate(array $coordinate, string $direction): array
    {
        switch ($direction) {
            case self::NORTH:
                $coordinate['y']--;
                break;
            case self::EAST:
                $coordinate['x']++;
                break;
            case self::SOUTH:
                $coordinate['y']++;
                break;
            case self::WEST:
                $coordinate['x']--;
        }

        return $coordinate;
    }

    /**
     * @param string[] $possibleDirections
     * @throws Exception
     */
    protected function getNextDirection(array $possibleDirections, string $lastDirection): string
    {
        foreach ($possibleDirections as $possibleDirection) {
            if (!$this->areOppositeDirections($possibleDirection, $lastDirection)) {
                return $possibleDirection;
            }
        }

        throw new Exception('no possible next direction');
    }

    protected function areOppositeDirections(string $first, string $second): bool
    {
        return (self::NORTH === $first && self::SOUTH === $second)
            || (self::SOUTH === $first && self::NORTH === $second)
            || (self::WEST === $first && self::EAST === $second)
            || (self::EAST === $first && self::WEST === $second);
    }

    /**
     * @param array{y: int, x: int} $coordinate
     */
    protected function isStartCoordinate(array $coordinate): bool
    {
        return $this->startCoordinate['y'] === $coordinate['y'] && $this->startCoordinate['x'] === $coordinate['x'];
    }
}
