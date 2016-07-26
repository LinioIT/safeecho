<?php

namespace Linio\SafeEcho\Decorator;

abstract class SafeEchoDecorator
{
    /**
     * Sets the wrapped hiddenString for safe output.
     *
     * @param string $openString
     * @param string $hiddenString
     * @param mixed|null $data
     *
     * @return string
     */
    abstract public function wrap($openString, $hiddenString, $data = null);

    /**
     * @param string $string
     * @param string $hiddenChar
     *
     * @return string
     */
    public function hide($string, $hiddenChar = '*')
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
            $hiddenArray[] = sprintf('%s%s', $word[0], str_repeat($hiddenChar, strlen($word) - 1));
        }

        return implode(' ', $hiddenArray);
    }
}
