<?php

namespace Vogaeael\AdventOfCode2023\day08\part02;

use Vogaeael\AdventOfCode2023\day08\part01\StepsWithMap;

class SimultaneouslyStepsWithMap extends StepsWithMap
{
    protected const PART = 2;
    protected const NODE_MAP_REGEX = '/([A-Z0-9]{3}) = \(([A-Z0-9]{3}), ([A-Z0-9]{3})\)/';

    /** @var string[] $startPoints */
    protected array $startPoints = [];

    public function run(string $input): float
    {
        $this->handleInput($input);
        $this->determineStartPoints();
        $stepsPerStartPoint = [];
        foreach ($this->startPoints as $startPoint) {
            $stepsPerStartPoint[$startPoint] = $this->howManyStepsUntilDestination($startPoint);
        }

        return $this->lcm(array_values($stepsPerStartPoint));
    }

    protected function determineStartPoints(): void
    {
        foreach (array_keys($this->nodeMap) as $array_key) {
            if ($this->isStart($array_key)) {
                $this->startPoints[] = $array_key;
            }
        }
    }

    protected function isStart(string $position): bool
    {
        return str_ends_with($position, 'A');
    }

    protected function isDestination(string $position): bool
    {
        return str_ends_with($position, 'Z');
    }

    protected function lcm(array $values): int
    {
        $result = null;
        foreach($values as $value) {
            if (null === $result) {
                $result = $value;
                continue;
            }
            $result = $this->lcmPair($result, $value);
        }

        return $result;
    }

    protected function lcmPair(int $first, int $second): int
    {
        return $first * $second / $this->gcd($first, $second);
    }

    protected function gcd(int $a, int $b): int
    {
        while ($b !== 0) {
            $oldA = $a;
            $a = $b;
            $b = $oldA % $b;
        }

        return $a;
    }
}
