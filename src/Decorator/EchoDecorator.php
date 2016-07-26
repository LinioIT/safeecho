<?php

namespace Linio\SafeEcho\Decorator;

class EchoDecorator extends SafeEchoDecorator
{
    /**
     * Sets the wrapped hiddenString for safe output.
     *
     * @param string $openString
     * @param string $hiddenString
     * @param mixed $data
     *
     * @return string
     */
    public function wrap($openString, $hiddenString, $data = null)
    {
        return $openString;
    }

    /**
     * @param string $string
     * @param string $hiddenChar
     *
     * @return string
     */
    public function hide($string, $hiddenChar = '*')
    {
        return $string;
    }
}
