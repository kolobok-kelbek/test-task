<?php

declare(strict_types=1);

namespace kelbek;

interface Reader
{
    public function open(string $filename): void;

    public function readLine(): ?string;

    public function close(): void;
}