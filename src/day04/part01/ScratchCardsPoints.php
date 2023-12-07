<?php

namespace Vogaeael\AdventOfCode2023\day04\part01;

use Vogaeael\AdventOfCode2023\AbstractTask;

class ScratchCardsPoints extends AbstractTask
{
    protected const DAY = 4;
    protected const PART = 1;

    /**
     * @inheritDoc
     */
    public function run(string $input): float
    {
        $input = $this->separateOnNewLine($input);
        $total = 0;

        foreach ($input as $inputCard) {
            if (empty($inputCard)) {
                continue;
            }
            $cardId = $this->getCardId($inputCard);
            $cardPoints = 0;
            $body = explode(': ', $inputCard)[1];
            $bodyParts = explode(' | ', $body);
            $winNumbers = $this->getNumbersOfInput($bodyParts[0]);
            $ownNumbers = $this->getNumbersOfInput($bodyParts[1]);

            foreach ($ownNumbers as $ownNumber) {
                if (in_array($ownNumber, $winNumbers)) {
                    if (0 === $cardPoints) {
                        $cardPoints = 1;
                        continue;
                    }
                    $cardPoints *= 2;
                }
            }

            $total += $cardPoints;
        }

        return $total;
    }

    protected function getCardId(string $inputCard): int
    {
        $matches = [];
        preg_match('/Card +(\d+): /', $inputCard, $matches);

        return (int)$matches[1];
    }
}
