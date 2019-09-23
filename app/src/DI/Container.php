<?php

namespace kelbek\DI;

use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Container implements ContainerInterface
{
    private const PATH_TO_CONFIG = __DIR__ . '/../../config';
    private const SERVICE_CONFIG = 'services.yml';

    /**
     * @var ContainerInterface
     */
    private static $container;

    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    /**
     * Container constructor.
     * @throws Exception
     */
    private function __construct()
    {
        $this->containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator(static::PATH_TO_CONFIG));
        $loader->load(static::SERVICE_CONFIG);
    }

    public static function getInstance(): ContainerInterface
    {
        if (null === static::$container) {
            static::$container = new Container();
        }

        return static::$container;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id): ?object
    {
        return $this->containerBuilder->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id): ?object
    {
        return $this->containerBuilder->get($id);
    }


}