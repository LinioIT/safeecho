<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

use PHPUnit\Framework\TestCase;

class NoWrapDecoratorTest extends TestCase
{
    public function testWrap(): void
    {
        $noWrapper = new NoWrapDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';

        $this->assertEquals($hiddenString, $noWrapper->wrap($openString, $hiddenString));
    }

    public function testHide(): void
    {
        $noWrapper = new NoWrapDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';

        $this->assertEquals($hiddenString, $noWrapper->hide($openString));
    }

    public function testHideChangeChar(): void
    {
        $noWrapper = new NoWrapDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P~~~~ m~~';

        $this->assertEquals($hiddenString, $noWrapper->hide($openString, '~'));
    }
}
