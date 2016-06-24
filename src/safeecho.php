<?php

declare(strict_types=1);

use Linio\SafeEcho\Exception\InvalidConfigurationFileException;
use Linio\SafeEcho\Factory\ConfigurationFactory;
use Linio\SafeEcho\Factory\DecoratorFactory;
use Noodlehaus\AbstractConfig;
use Noodlehaus\Exception\FileNotFoundException;

/**
 * Outputs or returns a string by the definition of the decorator.
 *
 * @param mixed $string The string to safely output or return. Cannot be object or array. Other types will be cast to string.
 * @param mixed $data Extra data needed by the decorator.
 * @param bool $return Output or return. Output default
 *
 * @throws FileNotFoundException
 * @throws InvalidConfigurationFileException
 *
 * @return string
 */
function safeecho($string, $data = null, bool $return = false)
{
    // arrays and objects are currently outside the scope of this project. Return or dump them.
    if (is_object($string) || is_array($string)) {
        if ($return) {
            return $string;
        }

        $output = var_export($string, true);

        echo $output;
    } else {

        //assert $string is a string
        $string = (string) $string;

        //get configuration: merges with default values, so decorator and hideChar are guaranteed to exist.
        /** @var AbstractConfig $configuration */
        $configuration = ConfigurationFactory::create();

        $decorator = DecoratorFactory::create($configuration->get('decorator'));

        $hiddenString = $decorator->hide($string, $configuration->get('hideChar'));

        $safeechoString = $decorator->wrap($string, $hiddenString, $data);

        if ($return) {
            return $safeechoString;
        }
        echo $safeechoString;
    }
}
