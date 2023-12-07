<?php

namespace Vogaeael\AdventOfCode2023\day04\part02;

use Vogaeael\AdventOfCode2023\day04\part01\ScratchCardsPoints;

class ScratchCardsPointsCopies extends ScratchCardsPoints
{
    protected const PART = 2;

    public function run(string $input): float
    {
        $input = $this->separateOnNewLine($input);
        $total = 0;

        $cardIdCopies = [];

        foreach ($input as $inputCard) {
            if (empty($inputCard)) {
                continue;
            }
            $cardId = $this->getCardId($inputCard);
            $cardIdCopies = $this->addCardToCardIdCopies($cardIdCopies, $cardId);
            $cardPoints = 0;
            $body = explode(': ', $inputCard)[1];
            $bodyParts = explode(' | ', $body);
            $winNumbers = $this->getNumbersOfInput($bodyParts[0]);
            $ownNumbers = $this->getNumbersOfInput($bodyParts[1]);

            foreach ($ownNumbers as $ownNumber) {
                if (in_array($ownNumber, $winNumbers)) {
                    $cardPoints++;
                }
            }

            for ($i = 1; $i <= $cardPoints; $i++) {
                $cardIdCopies = $this->addCardToCardIdCopies($cardIdCopies, $cardId + $i, $cardIdCopies[$cardId]);
            }

            $total += $cardIdCopies[$cardId];
        }

        return $total;
    }

    /**
     * @param array<int, int> $cardIdCopies
     *
     * @return array<int, int>
     */
    protected function addCardToCardIdCopies(array $cardIdCopies, int $cardId, ?int $howMany = 1): array
    {
        if (!array_key_exists($cardId, $cardIdCopies)) {
            $cardIdCopies[$cardId] = 0;
        }
        $cardIdCopies[$cardId] += $howMany;

        return $cardIdCopies;
    }

}
