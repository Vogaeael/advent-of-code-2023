<?php

namespace Vogaeael\AdventOfCode2023\day05\part02;

use Exception;
use Vogaeael\AdventOfCode2023\day05\part01\NearestSeedLocation;

class NearestSeedLocationRange extends NearestSeedLocation
{
    protected const PART = 2;

    /** @var array<int, array{sourceStart: int, destinationStart: int, length: int}> $seedsRange */
    protected array $seedsRange;

    /** @var array<int, array{sourceStart: int, destinationStart: int, length: int}> $completeMapping */
    protected array $completeMapping;

    /** @var int[] $lowest */
    protected array $lowest = [];

    /**
     * @throws Exception
     */
    public function run(string $input): float
    {
        $input = explode(PHP_EOL . PHP_EOL, $input);
        $this->setSeeds($input);
        $this->setMappings($input);

//        $this->addSeedsToCompleteMapping();
        foreach ($this->seedsRange as $seedRange) {
            $this->completeMapping = [$seedRange];
            $this->addMappingsToCompleteMapping();
            $newLowest = $this->getLowestDestinationOfCompleteMapping();
            $this->lowest[] = $newLowest;
            unset($this->completeMapping);
        }
//        $this->addMappingsToCompleteMapping();

        return min($this->lowest); //$this->getLowestDestinationOfCompleteMapping();
    }

    /**
     * @param string[] $input
     */
    protected function setSeeds(array $input): void
    {
        $numbers = $this->getNumbersOfInput($input[0]);
        $numbers = array_chunk($numbers, 2);
        foreach ($numbers as $number) {
            $this->seedsRange[] = [
                'sourceStart' => (int)$number[0],
                'destinationStart' => (int)$number[0],
                'length' => (int)$number[1]
            ];
        }
    }

    protected function addSeedsToCompleteMapping(): void
    {
        $this->completeMapping = $this->seedsRange;
    }

    protected function addMappingsToCompleteMapping(): void
    {
        $nextMap = 'seed';
        while (array_key_exists($nextMap, $this->mappings)) {
            $currentMappingWrapper = $this->mappings[$nextMap];
            $currentMapping = $currentMappingWrapper['mappings'];

            $this->extendCompleteMappingWithMappings($currentMapping);
            $nextMap = $currentMappingWrapper['to'];
        }
    }

    /**
     * @param array<int, array{sourceStart: int, destinationStart: int, length: int}> $mappingWrapper
     */
    protected function extendCompleteMappingWithMappings(array $mappingWrappers): void
    {
        $newCompleteMappingParts = [];
        foreach ($mappingWrappers as $mappingWrapper) {
            $newCompleteMappingParts = array_merge($newCompleteMappingParts, $this->extendCompleteMappingWithMapping($mappingWrapper));
        }

        $this->completeMapping = array_merge($this->completeMapping, $newCompleteMappingParts);
    }

    /**
     * @param array{sourceStart: int, destinationStart: int, length: int} $mappingWrapper
     *
     * @return array<int, array{sourceStart: int, destinationStart: int, length: int}>
     */
    protected function extendCompleteMappingWithMapping(array $mappingWrapper): array
    {
        $notRedirectedYetCollection = [
            $mappingWrapper
        ];
        $newCompleteMappingParts = [];
        $lastCompleteMappingKey = count($this->completeMapping) - 1;
        for ($i = 0; $i <= $lastCompleteMappingKey; $i++) {
            $oldMap = $this->completeMapping[$i];
            $oldMapLength = $oldMap['length'];
            $oldMapDestinationStart = $oldMap['destinationStart'];

            foreach ($notRedirectedYetCollection as $notRedirectedYet) {
                $notRedirectedYetLength = $notRedirectedYet['length'];
                $notRedirectedYetSourceStart = $notRedirectedYet['sourceStart'];

                $overlappingToChange = $this->calculateOverlapping(
                    [
                        'start' => $oldMapDestinationStart,
                        'length' => $oldMapLength
                    ],
                    [
                        'start' => $notRedirectedYetSourceStart,
                        'length' => $notRedirectedYetLength
                    ]
                );

                if (null === $overlappingToChange) {
                    continue;
                }
                $oldMapSourceStart = $oldMap['sourceStart'];

                $overlappingStart = $overlappingToChange['start'];
                $overlappingLength = $overlappingToChange['length'];
                $notRedirectedYetDestinationStart = $notRedirectedYet['destinationStart'];

                $newMapSourceStart = $oldMapSourceStart + ($overlappingStart - $oldMapDestinationStart);
                $newMapDestinationStart = $newMapSourceStart + ($oldMapDestinationStart - $oldMapSourceStart) - ($notRedirectedYetSourceStart - $notRedirectedYetDestinationStart);

                $newCompleteMappingParts[] = [
                    'sourceStart' => $newMapSourceStart,
                    'destinationStart' => $newMapDestinationStart,
                    'length' => $overlappingToChange['length']
                ];

                if ($overlappingStart === $oldMapDestinationStart) {
                    if ($overlappingLength === $oldMapLength) {
                        unset($this->completeMapping[$i]);
                    } else {
                        $oldMap['sourceStart'] = $oldMapSourceStart + $overlappingLength;
                        $oldMap['destinationStart'] = $oldMapDestinationStart + $overlappingLength;
                        $oldMap['length'] = $oldMapLength - $overlappingLength;
                        $this->completeMapping[$i] = $oldMap;
                    }
                } elseif ($overlappingStart + $overlappingLength === $oldMapDestinationStart + $oldMapLength) {
                    $oldMap['length'] = $oldMapLength - $overlappingLength;
                    $this->completeMapping[$i] = $oldMap;
                } else {
                    $oldMapPart2Length = $oldMapLength - $overlappingLength - ($overlappingStart - $oldMapDestinationStart);
                    $oldMap['length'] = $oldMapLength - $overlappingLength - $oldMapPart2Length;
                    $oldMapPart2 = [
                        'sourceStart' => $oldMapSourceStart + $oldMapLength - $oldMapPart2Length,
                        'destinationStart' => $overlappingStart + $overlappingLength,
                        'length' => $oldMapPart2Length
                    ];
                    $this->completeMapping[] = $oldMapPart2;
                    $lastCompleteMappingKey++;
                }
            }
        }
        $this->completeMapping = array_values($this->completeMapping);

        return $newCompleteMappingParts;
    }

    /**
     * @param array{start: int, length: int} $first
     * @param array{start: int, length: int} $second
     *
     * @return array{start: int, length: int}|null
     */
    protected function calculateOverlapping(array $first, array $second): ?array
    {
        $firstStart = $first['start'];
        $firstLength = $first['length'];
        $firstEnd = $firstStart + $firstLength - 1;

        $secondStart = $second['start'];
        $secondLength = $second['length'];
        $secondEnd = $secondStart + $secondLength - 1;

        if ($firstEnd < $secondStart || $secondEnd < $firstStart) {
            return null;
        }

        $firstStartBeforeSecond = $secondStart <=> $firstStart;
        $firstEndBeforeSecond = $secondEnd <=> $firstEnd;

        if (0 >= $firstStartBeforeSecond && 0 <= $firstEndBeforeSecond) {
            return $first;
        }

        if (0 <= $firstStartBeforeSecond && 0 >= $firstEndBeforeSecond) {
            return $second;
        }

        if (-1 === $firstStartBeforeSecond) {
            $length = $secondEnd - $firstStart + 1;

            return [
                'start' => $firstStart,
                'length' => $length
            ];
        }

        $length = $firstEnd - $secondStart + 1;

        return [
            'start' => $secondStart,
            'length' => $length
        ];
    }

    /**
     * @return int[]
     */
    protected function getAllSeedDestination(): array
    {
        $seedDestinations = [];
        foreach ($this->seedsRange as $seedRange) {
            for ($i = 0; $i < $seedRange['length']; $i++) {
                $seedDestinations[] = $this->getSeedDestination($seedRange['start'] + $i);
            }
        }

        return $seedDestinations;
    }

    protected function getSeedDestination(int $seed): int
    {
        return $this->getValueFromMapping($this->completeMapping, $seed);
    }

    /**
     * @throws Exception
     */
    protected function getLowestDestinationOfCompleteMapping(): int
    {
        $lowest = null;
        foreach ($this->completeMapping as $mapping) {
            $destinationStart = $mapping['destinationStart'];
            if (null === $lowest) {
                $lowest = $destinationStart;
                continue;
            }
            if ($lowest > $destinationStart) {
                $lowest = $destinationStart;
            }
        }

        if (null === $lowest) {
            throw new Exception('complete mapping not created yet');
        }

        return $lowest;
    }
}
