<?php

namespace Linio\SafeEcho\tests\Decorator;

use Linio\SafeEcho\Decorator\EchoDecorator;
use PHPUnit\Framework\TestCase;

class EchoDecoratorTest extends TestCase
{
    public function testWrap()
    {
        $noWrapper = new EchoDecorator();

        $openString = 'Print me!';

        $this->assertEquals($openString, $noWrapper->wrap($openString, $openString));
    }

    public function testHide()
    {
        $noWrapper = new EchoDecorator();

        $openString = 'Print me!';

        $this->assertEquals($openString, $noWrapper->hide($openString));
    }

    public function testHideChangeChar()
    {
        $noWrapper = new EchoDecorator();

        $openString = 'Print me!';

        $this->assertEquals($openString, $noWrapper->hide($openString, '~'));
    }
}
