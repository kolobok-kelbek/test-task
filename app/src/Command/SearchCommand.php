<?php

declare(strict_types=1);

namespace kelbek\Command;

use Symfony\Component\Console\{Command\Command, Input\InputArgument, Input\InputInterface, Output\OutputInterface};
use kelbek\Search\FileStringSearcher\Entity\ResultData;
use kelbek\Search\StringSearcher;

final class SearchCommand extends Command
{
    private const FILENAME_ARGUMENT = 'filename';
    private const SEARCH_STRING_ARGUMENT = 'search_string';

    /**
     * @var StringSearcher
     */
    private $stringSearcher;

    public function __construct(StringSearcher $stringSearcher, string $name = null)
    {
        parent::__construct($name);

        $this->stringSearcher = $stringSearcher;
    }

    protected function configure()
    {
        $this
            ->addArgument(static::FILENAME_ARGUMENT, InputArgument::REQUIRED)
            ->addArgument(static::SEARCH_STRING_ARGUMENT, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Start command \"{$this->getName()}\"");

        $filename = $input->getArgument(static::FILENAME_ARGUMENT);
        $searchString = $input->getArgument(static::SEARCH_STRING_ARGUMENT);

        /** @var ResultData[] $data */
        $data = $this->stringSearcher->search($filename, $searchString);

        $output->writeln('String found in:');

        foreach ($data as $resultData) {
            $item = sprintf(
                'Line: %d, positions: %s',
                $resultData->getPositionLine(),
                implode(', ', $resultData->getPositions())
            );

            $output->writeln($item);
        }

        $output->writeln("Finish command \"{$this->getName()}\"");
    }
}