<?php

namespace Linio\SafeEcho\Factory;

use Linio\SafeEcho\Decorator\SafeEchoDecorator;
use Linio\SafeEcho\Exception\InvalidConfigurationFileException;
use ReflectionClass;

class DecoratorFactory
{
    /**
     * @param mixed $decoratorConfiguration
     *
     * @throws InvalidConfigurationFileException
     *
     * @return SafeEchoDecorator
     */
    public static function create($decoratorConfiguration)
    {
        $decorator = null;

        if (is_string($decoratorConfiguration)) {
            $decorator = self::createFromString($decoratorConfiguration);
        } elseif (is_array($decoratorConfiguration)) {
            $decorator = self::createFromArray($decoratorConfiguration);
        }

        if (is_null($decorator)) {
            throw new InvalidConfigurationFileException('Cannot configure decorator.');
        }

        if (!is_a($decorator, SafeEchoDecorator::class)) {
            throw new InvalidConfigurationFileException('Decorator must be an instance of SafeEchoDecorator.');
        }

        return $decorator;
    }

    /**
     * @param string $decoratorClassName
     *
     * @return SafeEchoDecorator|null
     */
    private static function createFromString($decoratorClassName)
    {
        if (class_exists($decoratorClassName)) {
            return new $decoratorClassName();
        }

        return;
    }

    /**
     * @param array $decoratorConfiguration
     *
     * @return SafeEchoDecorator|null
     */
    private static function createFromArray(array $decoratorConfiguration)
    {
        if (array_key_exists('class', $decoratorConfiguration)) {
            $decoratorClassName = (string) $decoratorConfiguration['class'];

            if (class_exists($decoratorClassName)) {
                $reflection = new ReflectionClass($decoratorClassName);

                if (array_key_exists('arguments', $decoratorConfiguration)) {
                    return $reflection->newInstanceArgs($decoratorConfiguration['arguments']);
                }

                return $reflection->newInstanceArgs();
            }
        }

        return;
    }
}
