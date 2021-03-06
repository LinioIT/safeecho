<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Factory;

use Linio\SafeEcho\Decorator\SafeEchoDecorator;
use Linio\SafeEcho\Exception\InvalidConfigurationFileException;
use ReflectionClass;

class DecoratorFactory
{
    /**
     * @throws InvalidConfigurationFileException
     */
    public static function create($decoratorConfiguration): SafeEchoDecorator
    {
        $decorator = null;

        if (is_string($decoratorConfiguration)) {
            $decorator = self::createFromString($decoratorConfiguration);
        } elseif (is_array($decoratorConfiguration)) {
            $decorator = self::createFromArray($decoratorConfiguration);
        }

        if ($decorator === null) {
            throw new InvalidConfigurationFileException('Cannot configure decorator.');
        }

        if (!is_a($decorator, SafeEchoDecorator::class)) {
            throw new InvalidConfigurationFileException('Decorator must be an instance of SafeEchoDecorator.');
        }

        return $decorator;
    }

    /**
     * @return SafeEchoDecorator|null
     */
    private static function createFromString(string $decoratorClassName)
    {
        if (class_exists($decoratorClassName)) {
            return new $decoratorClassName();
        }
    }

    /**
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
    }
}
