<?php

namespace Linio\SafeEcho\Decorator;

class NoWrapDecorator extends SafeEchoDecorator
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
        return $hiddenString;
    }
}
