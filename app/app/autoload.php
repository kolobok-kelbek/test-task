<?php

use Composer\Autoload\ClassLoader;

require_once __DIR__.'/../vendor/autoload.php';

$classLoader = new ClassLoader();
$classLoader->addPsr4("kelbek\\Test\\", __DIR__, true);
$classLoader->register();
