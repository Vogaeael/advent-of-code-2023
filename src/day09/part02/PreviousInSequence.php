<?php

namespace Vogaeael\AdventOfCode2023\day09\part02;

use Vogaeael\AdventOfCode2023\day09\part01\NextInSequence;

class PreviousInSequence extends NextInSequence
{
    protected const PART = 2;

    /**
     * @param int[] $sequence
     * @param int[] $lowerLevelSequence
     *
     * @return int[]
     */
    protected function advanceSequenceWithAdvancedLowerSequence(array $sequence, array $lowerLevelSequence): array
    {
        $reverseSequence = array_reverse($sequence);
        $reverseLowerLevelSequence = array_reverse($lowerLevelSequence);

        for ($i = count($reverseSequence) - 1; $i < count($reverseLowerLevelSequence); $i++) {
            $step = $reverseLowerLevelSequence[$i];
            $reverseSequence[$i + 1] = $reverseSequence[$i] - $step;
        }

        return array_reverse($reverseSequence);
    }

    protected function getTotalOfNewValuesInMainSequence(): int
    {
        $total = 0;
        foreach ($this->sequenceWrapperCollection as $sequenceWrapper) {
            $total += $sequenceWrapper[0][0];
        }

        return $total;
    }
}
