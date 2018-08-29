<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

class NoWrapDecorator extends SafeEchoDecorator
{
    /**
     * Sets the wrapped hiddenString for safe output.
     */
    public function wrap(string $openString, string $hiddenString, $data = null): string
    {
        return $hiddenString;
    }
}
