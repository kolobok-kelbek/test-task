<?php

namespace kelbek\Test\Unit\Search\Worker;

use InvalidArgumentException;
use kelbek\Search\Worker\StringEntranceWorker;
use kelbek\Search\Worker\StringEntranceWorker\Entity\InputData;
use PHPUnit\Framework\TestCase;
use stdClass;

class StringEntranceWorkerTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testWork()
    {
        $worker = new StringEntranceWorker();

        $data = new InputData('it', 'fdsafdsa it fdsaf ait gfdsg itgi tigs');

        $result = $worker->work($data);

        self::assertSame($result, [9, 19, 28]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testWork1()
    {
        $worker = new StringEntranceWorker();

        $data = new InputData('it', 'fdsafd');

        $result = $worker->work($data);

        self::assertNull($result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testWorkWithInvalidArgumentException()
    {
        $worker = new StringEntranceWorker();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Only accepts ' . InputData::class . '.');

        $worker->work(new stdClass());
    }
}
