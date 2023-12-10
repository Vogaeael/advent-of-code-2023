<?php

namespace Vogaeael\AdventOfCode2023\day05\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class NearestSeedLocation extends AbstractTask
{
    protected const DAY = 5;
    protected const PART = 1;

    protected const REGEX_MAPPINGS_WRAPPER = '/^(.+)-to-(.+) map:\n((\d+ \d+ \d+\n?)+$)/';

    /** @var int[] $seeds */
    protected array $seeds = [];

    /** @var array<string, array{to: string, mappings: array<int, array{sourceStart: int, destinationStart: int, length: int}>}> */
    protected array $mappings = [];

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $input = explode(PHP_EOL . PHP_EOL, $input);
        $this->setSeeds($input);
        $this->setMappings($input);

        return min($this->getAllSeedDestination());
    }

    /**
     * @param string[] $input
     */
    protected function setSeeds(array $input): void
    {
        $this->seeds = $this->getNumbersOfInput($input[0]);
    }

    protected function setMappings(array $input): void
    {
        $mapWrapperStrings = array_slice($input, 1);
        foreach($mapWrapperStrings as $mapWrapperString) {
            $matches = [];
            preg_match_all(static::REGEX_MAPPINGS_WRAPPER, $mapWrapperString, $matches);
            $this->mappings[$matches[1][0]] = [
                'to' => $matches[2][0],
                'mappings' => $this->transformMappingStringIntoMaps($matches[3][0])
            ];

        }
    }

    /**
     * @return array<int, array{sourceStart: int, destinationStart: int, length: int}>
     */
    protected function transformMappingStringIntoMaps(string $mappingStrings): array
    {
        $mappingStrings = explode(PHP_EOL, $mappingStrings);

        $maps = [];
        foreach ($mappingStrings as $mappingString) {
            if (empty ($mappingString)) {
                continue;
            }
            $numbers = $this->getNumbersOfInput($mappingString);
            $maps[] = [
                'sourceStart' => (int)$numbers[1],
                'destinationStart' => (int)$numbers[0],
                'length' => (int)$numbers[2]
            ];
        }

        return $maps;
    }

    /**
     * @return int[]
     */
    protected function getAllSeedDestination(): array
    {
        $seedDestinations = [];
        foreach ($this->seeds as $seed) {
            $seedDestinations[] = $this->getSeedDestination($seed);
        }

        return $seedDestinations;
    }

    protected function getSeedDestination(int $seed): int
    {
        $nextMap = 'seed';
        while (array_key_exists($nextMap, $this->mappings)) {
            $currentMappingWrapper = $this->mappings[$nextMap];
            $nextMap = $currentMappingWrapper['to'];
            $currentMapping = $currentMappingWrapper['mappings'];

            $seed = $this->getValueFromMapping($currentMapping, $seed);
        }

        return $seed;
    }

    /**
     * @param array<int, array{sourceStart: int, destinationStart: int, length: int}> $maps
     */
    protected function getValueFromMapping(array $maps, int $startValue): int
    {
        foreach ($maps as $map) {
            $sourceStart = $map['sourceStart'];
            $sourceEnd = $sourceStart + $map['length'];

            if ($startValue >= $sourceStart && $startValue <= $sourceEnd) {
                $aboveStart = $startValue - $sourceStart;
                return $map['destinationStart'] + $aboveStart;
            }
        }

        return $startValue;
    }
}
