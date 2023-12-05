<?php declare(strict_types=1);

require 'vendor/autoload.php';

use Vogaeael\AdventOfCode2023\TaskCollection;
use Vogaeael\AdventOfCode2023\day01\part01\TrebuchetCalibration;

try {
    $tasks = new TaskCollection();
    $tasks->add([
        new TrebuchetCalibration(),
        // @TODO add all tasks
    ]);

    $day = (int)$argv[1];
    $part = (int)$argv[2];

    $filePath = sprintf('var/%d/%d/input.txt', $day, $part);
    validateFile($filePath);
    $input = file_get_contents($filePath);

    $task = $tasks->get($day, $part);
    $result = $task->run($input);

    echo "\033[1;33m" . $result . "\033[0m" . PHP_EOL;
} catch(Exception $e) {
    echo "\033[0;31m" . $e->getMessage() . "\033[0m" . PHP_EOL;
}

/**
 * @throws Exception
 */
function validateFile(string $filePath): void
{
    if (!file_exists($filePath)) {
        throw new Exception(sprintf('File `%s` does not exist', $filePath));
    }
    if (!is_file($filePath)) {
        throw new Exception(sprintf('`%s` is not a file', $filePath));
    }
    if (!is_readable($filePath)) {
        throw new Exception(sprintf('File `%s` is not readable', $filePath));
    }
}
