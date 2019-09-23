<?php

declare(strict_types=1);

namespace kelbek\Search;

interface StringSearcher
{
    public function search(string $filename, string $searchString);
}