<?php

declare(strict_types=1);

namespace kelbek\Searcher\Worker;

use InvalidArgumentException;
use kelbek\Search\Worker;
use kelbek\Searcher\Worker\StringEntranceWorker\Entity\InputData;
use function stripos;

final class StringEntranceWorker implements Worker
{
    /**
     * @param InputData|object $data
     * @return int[]|null
     */
    public function work(object $data): ?array
    {
        if (!$data instanceof InputData) {
            throw new InvalidArgumentException('Only accepts ' . InputData::class . '.');
        }

        $pos = 0;
        $positions = [];

        while (true) {
            $pos = stripos($data->getLine(), $data->getSearchText(), $pos);

            if (false === $pos) {
                break;
            }

            $positions[] = $pos;

            $pos++;
        }

        return $positions ?: null;
    }
}