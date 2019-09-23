<?php

declare(strict_types=1);

namespace kelbek\Search;

interface Worker
{
    public function work(object $data);
}