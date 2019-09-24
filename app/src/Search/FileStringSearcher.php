<?php

declare(strict_types=1);

namespace kelbek\Search;

use kelbek\Reader;
use kelbek\Search\FileStringSearcher\Entity\ResultData;
use kelbek\Search\Worker\StringEntranceWorker\Entity\InputData;

final class FileStringSearcher implements StringSearcher
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Worker
     */
    private $worker;

    /**
     * FileSearcher constructor.
     * @param Reader $reader
     * @param Worker $worker
     */
    public function __construct(Reader $reader, Worker $worker)
    {
        $this->reader = $reader;
        $this->worker = $worker;
    }

    public function search(string $filename, string $searchString)
    {
        $count = 0;
        $this->reader->open($filename);
        $resultDataList = [];

        while (true) {
            $line = $this->reader->readLine();

            if (null === $line) {
                break;
            }

            /** @var int[] $positions */
            $positions = $this->worker->work(new InputData($searchString, $line));

            $count++;

            if (empty($positions)) {
                continue;
            }

            $resultDataList[] = new ResultData($count, $positions);
        }

        return $resultDataList;
    }
}