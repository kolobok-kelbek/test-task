<?php

declare(strict_types=1);

namespace kelbek\Helper;

final class ClassHelper
{
    public static function getOnlyNamespace(string $className): string
    {
        return substr($className, 0, strrpos($className, '\\'));
    }
}