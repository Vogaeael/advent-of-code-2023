<?php

namespace Vogaeael\AdventOfCode2023\day06\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class BoatRaceHowManyWaysToWin extends AbstractTask
{
    protected const DAY = 6;
    protected const PART = 1;

    /** @var array<int, array{timeLimit: int, bestRecord: int}> */
    protected array $races = [];

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $this->determineRaces($input);

        $total = 1;

        foreach ($this->races as $race) {
            $howManyWaysToWin = $this->howManyWaysCanYouWin($race);
            $total *= $howManyWaysToWin;
        }

        return $total;
    }

    protected function determineRaces(string $input): void
    {
        $input = $this->separateOnNewLine($input);
        $timeLimits = $this->getNumbersOfInput($input[0]);
        $bestRecords = $this->getNumbersOfInput($input[1]);

        foreach($timeLimits as $key => $timeLimit) {
            $this->races[$key] = [
                'timeLimit' => $timeLimit,
                'bestRecord' => $bestRecords[$key]
            ];
        }
    }

    /**
     * @param array{timeLimit: int, bestRecord: int} $race
     */
    protected function howManyWaysCanYouWin(array $race): int
    {
        $howManyWaysYouCanWin = 0;
        $timeLimit = $race['timeLimit'];
        $bestRecord = $race['bestRecord'];
        for ($millisecondsHold = 0; $millisecondsHold <= $timeLimit; $millisecondsHold++) {
            $distanceReached = $this->howFarDoIReach($millisecondsHold, $timeLimit);
            if ($distanceReached > $bestRecord) {
                $howManyWaysYouCanWin++;
            }
        }

        return $howManyWaysYouCanWin;
    }

    protected function howFarDoIReach(int $millisecondsHold, int $timeLimit): int
    {
        $timeRemaining = $timeLimit - $millisecondsHold;

        return $millisecondsHold * $timeRemaining;
    }
}
