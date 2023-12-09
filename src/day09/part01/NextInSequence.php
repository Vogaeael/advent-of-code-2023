<?php

namespace Vogaeael\AdventOfCode2023\day09\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class NextInSequence extends AbstractTask
{
    protected const DAY = 9;
    protected const PART = 1;

    /** @var array<int, array<int, int[]>> */
    protected array $sequenceWrapperCollection = [];

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $this->addInputAsMainSequencesIntoSequenceWrapper($input);
        $this->advanceSequenceWrapperWithLowerLevel();
        $this->advanceSequenceWrapperWithSteps();

        return $this->getTotalOfNewValuesInMainSequence();
    }

    protected function addInputAsMainSequencesIntoSequenceWrapper(string $input): void
    {
        $input = $this->separateOnNewLine($input);
        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }
            $numbers = $this->getNumbersOfInput($line);
            $numbers = $this->castStringArrayToIntArray($numbers);
            $this->sequenceWrapperCollection[][0] = $numbers;
        }
    }

    protected function advanceSequenceWrapperWithLowerLevel(): void
    {
        foreach ($this->sequenceWrapperCollection as $key => $sequenceWrapper) {
            $lowerLevelSequences = $this->calculateLowerLevelSequences($sequenceWrapper[0]);
            foreach ($lowerLevelSequences as $lowerLevelSequence) {
                $sequenceWrapper[] = $lowerLevelSequence;
            }
            $this->sequenceWrapperCollection[$key] = $sequenceWrapper;
        }
    }

    /**
     * @param int[] $sequence
     *
     * @return array<int, int[]>
     */
    protected function calculateLowerLevelSequences(array $sequence): array
    {
        $lowerLevelSequences = [];
        $currentSequence = $sequence;
        while (!$this->isLastSequence($currentSequence)) {
            $currentSequence = $this->calculateNextLevelSequence($currentSequence);
            $lowerLevelSequences[] = $currentSequence;
        }

        return $lowerLevelSequences;
    }

    /**
     * @param int[] $mainSequence
     *
     * @return int[]
     */
    protected function calculateNextLevelSequence(array $mainSequence): array
    {
        $nextLevelSequence = [];
        for ($i = 1; $i < count($mainSequence); $i++) {
            $nextLevelSequence[] = $mainSequence[$i] - $mainSequence[$i - 1];
        }

        return $nextLevelSequence;
    }

    /**
     * @param int[] $sequence
     */
    protected function isLastSequence(array $sequence): bool
    {
        foreach ($sequence as $item) {
            if (0 !== $item) {
                return false;
            }
        }

        return true;
    }

    protected function advanceSequenceWrapperWithSteps(?int $steps = 1): void
    {
        foreach ($this->sequenceWrapperCollection as $key => $sequenceWrapper) {
            $sequenceWrapper = $this->advanceLastSequenceWithZeros($sequenceWrapper, $steps);

            for ($i = count($sequenceWrapper) - 2; $i >= 0; $i--) {
                $sequenceWrapper[$i] = $this->advanceSequenceWithAdvancedLowerSequence($sequenceWrapper[$i], $sequenceWrapper[$i + 1]);
            }

            $this->sequenceWrapperCollection[$key] = $sequenceWrapper;
        }
    }

    protected function advanceLastSequenceWithZeros(array $sequenceWrapper, ?int $howMany = 1): array
    {
        $lastLevelSequence = end($sequenceWrapper);
        for ($i = 0; $i < $howMany; $i++) {
            $lastLevelSequence[] = 0;
        }
        $sequenceWrapper[count($sequenceWrapper) - 1] = $lastLevelSequence;

        return $sequenceWrapper;
    }

    /**
     * @param int[] $sequence
     * @param int[] $lowerLevelSequence
     *
     * @return int[]
     */
    protected function advanceSequenceWithAdvancedLowerSequence(array $sequence, array $lowerLevelSequence): array
    {
        for ($i = count($sequence) - 1; $i < count($lowerLevelSequence); $i++) {
            $step = $lowerLevelSequence[$i];
            $sequence[$i + 1] = $sequence[$i] + $step;
        }

        return $sequence;
    }

    protected function getTotalOfNewValuesInMainSequence(): int
    {
        $total = 0;
        foreach ($this->sequenceWrapperCollection as $sequenceWrapper) {
            $total += end($sequenceWrapper[0]);
        }

        return $total;
    }
}
