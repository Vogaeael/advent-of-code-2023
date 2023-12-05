<?php

namespace Vogaeael\AdventOfCode2023;

interface TaskInterface
{
    public function run(string $input): float;

    public function getDay(): int;

    public function getPart(): int;
}
