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
}
