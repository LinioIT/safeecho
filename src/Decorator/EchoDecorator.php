<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

class EchoDecorator extends SafeEchoDecorator
{
    /**
     * Sets the wrapped hiddenString for safe output.
     */
    public function wrap(string $openString, string $hiddenString, $data = null): string
    {
        return $openString;
    }

    /**
     * @return string
     */
    public function hide(string $string, string $hiddenChar = '*')
    {
        return $string;
    }
}
