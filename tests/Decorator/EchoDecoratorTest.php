<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

use PHPUnit\Framework\TestCase;

class EchoDecoratorTest extends TestCase
{
    public function testWrap(): void
    {
        $noWrapper = new EchoDecorator();

        $openString = 'Print me!';

        $this->assertEquals($openString, $noWrapper->wrap($openString, $openString));
    }

    public function testHide(): void
    {
        $noWrapper = new EchoDecorator();

        $openString = 'Print me!';

        $this->assertEquals($openString, $noWrapper->hide($openString));
    }

    public function testHideChangeChar(): void
    {
        $noWrapper = new EchoDecorator();

        $openString = 'Print me!';

        $this->assertEquals($openString, $noWrapper->hide($openString, '~'));
    }
}
