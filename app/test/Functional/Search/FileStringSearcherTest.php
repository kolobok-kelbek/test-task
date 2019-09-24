<?php

namespace kelbek\Test\Functional\Search;

use kelbek\FileReader;
use kelbek\Search\FileStringSearcher;
use kelbek\Search\FileStringSearcher\Entity\ResultData;
use kelbek\Search\Worker\StringEntranceWorker;
use PHPUnit\Framework\TestCase;

class FileStringSearcherTest extends TestCase
{
    private const PATH_TO_RESOURCES = __DIR__ . '/../../Resources/FileFixtures';

    /**
     * @runInSeparateProcess
     */
    public function testReadTextFile()
    {
        /** @var ResultData[] $data */
        $data = $this->getSearcher()->search(static::PATH_TO_RESOURCES . '/test.txt', 'it');

        $result = [];

        foreach ($data as $resultData) {
            $result[] = sprintf(
                'Line: %d, positions: %s',
                $resultData->getPositionLine(),
                implode(', ', $resultData->getPositions())
            );
        }

        $this->assertSame(
            $result,
            [
                'Line: 1, positions: 61, 90, 106',
                'Line: 2, positions: 0, 86',
                'Line: 3, positions: 79, 86',
                'Line: 4, positions: 33'
            ]
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function testReadTextFile2()
    {
        /** @var ResultData[] $data */
        $data = $this->getSearcher()->search(static::PATH_TO_RESOURCES . '/test.txt', 'application');

        $result = [];

        foreach ($data as $resultData) {
            $result[] = sprintf(
                'Line: %d, positions: %s',
                $resultData->getPositionLine(),
                implode(', ', $resultData->getPositions())
            );
        }

        $this->assertSame($result, ['Line: 7, positions: 27']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testReadTextFile3()
    {
        /** @var ResultData[] $data */
        $data = $this->getSearcher()->search(static::PATH_TO_RESOURCES . '/test.txt', 'turbo_application');

        $result = [];

        foreach ($data as $resultData) {
            $result[] = sprintf(
                'Line: %d, positions: %s',
                $resultData->getPositionLine(),
                implode(', ', $resultData->getPositions())
            );
        }

        $this->assertSame($result, []);
    }

    /**
     * @runInSeparateProcess
     */
    public function testReadTextFile4()
    {
        /** @var ResultData[] $data */
        $data = $this->getSearcher()->search(static::PATH_TO_RESOURCES . '/test.txt', '');

        $result = [];

        foreach ($data as $resultData) {
            $result[] = sprintf(
                'Line: %d, positions: %s',
                $resultData->getPositionLine(),
                implode(', ', $resultData->getPositions())
            );
        }

        $this->assertSame($result, []);
    }

    private function getSearcher(): FileStringSearcher
    {
        return new FileStringSearcher(new FileReader(2048), new StringEntranceWorker());
    }
}
