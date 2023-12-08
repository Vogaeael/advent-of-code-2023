<?php

namespace Vogaeael\AdventOfCode2023\day08\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class StepsWithMap extends AbstractTask
{
    protected const DAY = 8;
    protected const PART = 1;

    protected const LEFT = 'L';
    protected const RIGHT = 'R';
    protected const START = 'AAA';
    protected const DESTINATION = 'ZZZ';

    protected const NODE_MAP_REGEX = '/([A-Z]{3}) = \(([A-Z]{3}), ([A-Z]{3})\)/';

    /** @var string[] $instructions */
    protected array $instructions = [];
    /** @var array<string, array{L: string, R: string}> */
    protected array $nodeMap = [];

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $this->handleInput($input);

        return $this->howManyStepsUntilDestination();
    }

    protected function handleInput(string $input): void
    {
        $parts = explode(PHP_EOL . PHP_EOL, $input);
        $this->handleInstructionsInput($parts[0]);
        $this->handleNodeMapInput($parts[1]);
    }

    protected function handleInstructionsInput(string $instructions): void
    {
        $this->instructions = str_split($instructions);
    }

    protected function handleNodeMapInput(string $nodeMaps): void
    {
        $nodeMaps = $this->separateOnNewLine($nodeMaps);
        foreach ($nodeMaps as $nodeMap) {
            if (empty($nodeMap)) {
                continue;
            }
            $matches = [];
            preg_match(static::NODE_MAP_REGEX, $nodeMap, $matches);
            $this->nodeMap[$matches[1]] = [
                static::LEFT => $matches[2],
                static::RIGHT => $matches[3]
            ];
        }
    }

    protected function howManyStepsUntilDestination(): int
    {
        $steps = 0;
        $currentPosition = static::START;
        while (static::DESTINATION !== $currentPosition) {
            $steps++;
            $currentDirection = $this->determineDirectionOfStep($steps);
            $currentNodeMap = $this->nodeMap[$currentPosition];
            $currentPosition = $currentNodeMap[$currentDirection];
        }

        return $steps;
    }

    protected function determineDirectionOfStep(int $step): string
    {
        $modular = ($step - 1) % count($this->instructions);

        return $this->instructions[$modular];
    }
}
