<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Factory;

use Linio\SafeEcho\Decorator\NoWrapDecorator;
use Noodlehaus\AbstractConfig;
use Noodlehaus\Config;
use Noodlehaus\Exception\FileNotFoundException;

/**
 * Default configuration file. Used in the absence of a configuration file.
 * Or, it is merged with the existing configuration to assert all fields exist.
 */
class SafeEchoDefaultConfig extends AbstractConfig
{
    protected function getDefaults()
    {
        return [
            'decorator' => NoWrapDecorator::class,
            'hideChar' => '*',
        ];
    }
}

class ConfigurationFactory
{
    /**
     * Retrieves the Configuration.
     *
     * @throws FileNotFoundException
     *
     * @return AbstractConfig
     */
    public static function create(): AbstractConfig
    {
        $configuration = self::recurseExtensions();

        if (!is_null($configuration)) {
            return new SafeEchoDefaultConfig($configuration->all());
        }

        return new SafeEchoDefaultConfig([]);
    }

    /**
     * Recursively try all the possible combinations of the configuration file. Return the first successful match.
     *
     * @param int $idx
     *
     * @return AbstractConfig|null
     */
    private static function recurseExtensions(int $idx = 0)
    {
        $extensions = self::getExtensions();

        if ($idx < count($extensions)) {
            try {
                return Config::load(sprintf('%s.%s', self::getConfigName(), $extensions[$idx]));
            } catch (FileNotFoundException $notFoundException) {
                return self::recurseExtensions(++$idx);
            }
        }

        return;
    }

    /**
     * Get all the possible extensions for the configuration file.
     *
     * @return array
     */
    private static function getExtensions()
    {
        return ['ini', 'json', 'php', 'xml', 'yaml', 'yml'];
    }

    /**
     * Get the name of the configuration file.
     *
     * @return string
     */
    private static function getConfigName()
    {
        return 'safeecho';
    }
}
