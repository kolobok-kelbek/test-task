<?php

declare(strict_types=1);

namespace kelbek\Search\Worker\StringEntranceWorker\Entity;

final class InputData
{
    /**
     * @var string
     */
    private $searchText;

    /**
     * @var string
     */
    private $line;

    /**
     * StringEntranceWorker constructor.
     * @param string $searchText
     * @param string $line
     */
    public function __construct(string $searchText, string $line)
    {
        $this->searchText = $searchText;
        $this->line = $line;
    }

    /**
     * @return string
     */
    public function getSearchText(): string
    {
        return $this->searchText;
    }

    /**
     * @param string $searchText
     */
    public function setSearchText(string $searchText): void
    {
        $this->searchText = $searchText;
    }

    /**
     * @return string
     */
    public function getLine(): string
    {
        return $this->line;
    }

    /**
     * @param string $line
     */
    public function setLine(string $line): void
    {
        $this->line = $line;
    }


}