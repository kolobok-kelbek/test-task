<?php

declare(strict_types=1);

namespace kelbek\Search\FileStringSearcher\Entity;

final class ResultData
{
    /**
     * @var int
     */
    private $positionLine;

    /**
     * @var int[]
     */
    private $positions;

    /**
     * ResultData constructor.
     * @param int $positionLine
     * @param int[] $positions
     */
    public function __construct(int $positionLine, array $positions)
    {
        $this->positionLine = $positionLine;
        $this->positions = $positions;
    }

    /**
     * @return int
     */
    public function getPositionLine(): int
    {
        return $this->positionLine;
    }

    /**
     * @param int $positionLine
     */
    public function setPositionLine(int $positionLine): void
    {
        $this->positionLine = $positionLine;
    }

    /**
     * @return int[]
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /**
     * @param int[] $positions
     */
    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
    }
}