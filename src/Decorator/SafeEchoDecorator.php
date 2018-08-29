<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

abstract class SafeEchoDecorator
{
    /**
     * Sets the wrapped hiddenString for safe output.
     *
     * @param mixed|null $data
     */
    abstract public function wrap(string $openString, string $hiddenString, $data = null): string;

    /**
     * @return string
     */
    public function hide(string $string, string $hiddenChar = '*')
    {
        if (empty($string)) {
            return $string;
        }
        if (empty($hiddenChar)) {
            $hiddenChar = '*';
        } else {
            $hiddenChar = $hiddenChar[0];
        }

        $wordArray = explode(' ', (string) $string);

        $hiddenArray = [];

        foreach ($wordArray as $word) {
            if (strlen($word) > 0) {
                $hiddenArray[] = sprintf('%s%s', $word[0], str_repeat($hiddenChar, strlen($word) - 1));
            }
        }

        return implode(' ', $hiddenArray);
    }
}
