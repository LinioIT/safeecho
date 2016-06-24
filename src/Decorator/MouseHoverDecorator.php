<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

class MouseHoverDecorator extends SafeEchoDecorator
{
    /**
     * Sets the wrapped hiddenString for safe output.
     *
     * @param string $openString
     * @param string $hiddenString
     * @param null $data
     *
     * @return string
     */
    public function wrap(string $openString, string $hiddenString, $data = null): string
    {
        return sprintf(
            '<span style="cursor: pointer;" onmouseout="this.innerHTML=\'%2$s\'" onmouseover="this.innerHTML=\'%1$s\'">%2$s</span>',
            $openString,
            $hiddenString
        );
    }
}
