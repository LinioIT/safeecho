<?php

namespace Linio\SafeEcho\tests\Decorator;

use Linio\SafeEcho\Decorator\NoWrapDecorator;
use PHPUnit\Framework\TestCase;

class NoWrapDecoratorTest extends TestCase
{
    public function testWrap()
    {
        $noWrapper = new NoWrapDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';

        $this->assertEquals($hiddenString, $noWrapper->wrap($openString, $hiddenString));
    }

    public function testHide()
    {
        $noWrapper = new NoWrapDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';

        $this->assertEquals($hiddenString, $noWrapper->hide($openString));
    }

    public function testHideChangeChar()
    {
        $noWrapper = new NoWrapDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P~~~~ m~~';

        $this->assertEquals($hiddenString, $noWrapper->hide($openString, '~'));
    }
}
