<?php

namespace Vogaeael\AdventOfCode2023\day07\part01;

use Exception;
use Vogaeael\AdventOfCode2023\AbstractTask;
use Vogaeael\AdventOfCode2023\day07\part01\type\DetermineTypeInterface;

class CamelCards extends AbstractTask
{
    protected const DAY = 7;
    protected const PART = 1;

    public const TYPE_FIVE_KIND = 'five_of_a_kind';
    public const TYPE_FOUR_KIND = 'four_of_a_kind';
    public const TYPE_THREE_KIND = 'three_of_a_kind';
    public const TYPE_ONE_PAIR = 'one_pair';
    public const TYPE_TWO_PAIR = 'two_pair';
    public const TYPE_FULL_HOUSE = 'full_house';
    public const TYPE_HIGH_CARD = 'high_card';

    protected const TYPE_ORDER = [
        self::TYPE_FIVE_KIND => 0,
        self::TYPE_FOUR_KIND => 1,
        self::TYPE_FULL_HOUSE => 2,
        self::TYPE_THREE_KIND => 3,
        self::TYPE_TWO_PAIR => 4,
        self::TYPE_ONE_PAIR => 5,
        self::TYPE_HIGH_CARD => 6,
    ];

    protected const CARD_ORDER = [
        'A' => 0,
        'K' => 1,
        'Q' => 2,
        'J' => 3,
        'T' => 4,
        '9' => 5,
        '8' => 6,
        '7' => 7,
        '6' => 8,
        '5' => 9,
        '4' => 10,
        '3' => 11,
        '2' => 12
    ];

    /** @var array<int, array{hand: string, bid: int, type: string, winning?: int}> */
    protected array $handsWrapper = [];

    /**
     * @param DetermineTypeInterface[] $determineTypeCollection
     */
    public function __construct(
        protected readonly array $determineTypeCollection
    ) {}

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function run(string $input): float
    {
        $this->fillHandsWrapper($input);
        $this->sortHandWrapperForWinner();
        $this->calculateWinnings();

        return $this->addAllWinningsTogether();
    }

    /**
     * @throws Exception
     */
    protected function fillHandsWrapper(string $input): void
    {
        $input = $this->separateOnNewLine($input);
        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }
            $parts = explode(' ', $line);
            $this->handsWrapper[] = [
                'hand' => $parts[0],
                'bid' => $parts[1],
                'type' => $this->determineType($parts[0])
            ];
        }
    }

    /**
     * @throws Exception
     */
    protected function determineType(string $hand): string
    {
        $howManyOfWhichCard = $this->howManyOfWhichCard($hand);
        foreach ($this->determineTypeCollection as $determineType) {
            if ($determineType->isType($howManyOfWhichCard)) {
                return $determineType->getTypeName();
            }
        }

        throw new Exception('Type of hand not found');
    }

    /**
     * @return array<string, int>
     */
    protected function howManyOfWhichCard(string $hand): array
    {
        $result = [];
        foreach (str_split($hand) as $char) {
            if (!array_key_exists($char, $result)) {
                $result[$char] = 0;
            }
            $result[$char]++;
        }

        return $result;
    }

    protected function sortHandWrapperForWinner(): void
    {
        usort($this->handsWrapper, [static::class, 'compareHands']);
    }

    /**
     * @param array{hand: string, bid: int, type: string} $first
     * @param array{hand: string, bid: int, type: string} $second
     */
    static protected function compareHands(array $first, array $second): int
    {
        $result = static::compareHandsByType($first, $second);

        if (0 !== $result) {
            return $result;
        }

        return static::compareHandsByCards($first, $second);
    }

    /**
     * @param array{hand: string, bid: int, type: string} $first
     * @param array{hand: string, bid: int, type: string} $second
     */
    static protected function compareHandsByType(array $first, array $second): int
    {
        $firstTypeValue = static::TYPE_ORDER[$first['type']];
        $secondTypeValue = static::TYPE_ORDER[$second['type']];

        return $secondTypeValue <=> $firstTypeValue;
    }

    /**
     * @param array{hand: string, bid: int, type: string} $first
     * @param array{hand: string, bid: int, type: string} $second
     */
    static protected function compareHandsByCards(array $first, array $second): int
    {
        $firstCards = str_split($first['hand']);
        $secondCards = str_split($second['hand']);

        foreach ($firstCards as $key => $firstCard) {
            if (static::CARD_ORDER[$firstCard] < static::CARD_ORDER[$secondCards[$key]]) {
                return 1;
            }
            if (static::CARD_ORDER[$firstCard] > static::CARD_ORDER[$secondCards[$key]]) {
                return -1;
            }
        }

        return 0;
    }

    protected function calculateWinnings(): void
    {
        foreach ($this->handsWrapper as $place => $hand) {
            $hand['winning'] = ($place + 1) * $hand['bid'];
            $this->handsWrapper[$place] = $hand;
        }
    }

    protected function addAllWinningsTogether()
    {
        $total = 0;
        foreach ($this->handsWrapper as $hand) {
            $total += $hand['winning'];
        }

        return $total;
    }
}
