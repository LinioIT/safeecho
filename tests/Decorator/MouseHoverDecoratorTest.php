<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

use PHPUnit\Framework\TestCase;

class MouseHoverDecoratorTest extends TestCase
{
    public function testWrap(): void
    {
        $linioWrapper = new MouseHoverDecorator();

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';
        $span = '<span style="cursor: pointer;" onmouseout="this.innerHTML=\'P**** m**\'" onmouseover="this.innerHTML=\'Print me!\'">P**** m**</span>';
        //$span = '/^<span style="cursor: pointer;" onmouseout=\'[\\S]+\\(this, "[\\S]+"\\); function [\\S]+\\(e,t\\){if\\("span"==e\\.tagName\\.toLowerCase\\(\\)&&void 0!=t\\){var r=e\\.innerHTML;try{var c;try{c=new XMLHttpRequest}catch\\(o\\){try{c=new ActiveXObject\\("Msxml2\\.XMLHTTP"\\)}catch\\(o\\){try{c=new ActiveXObject\\("Microsoft\\.XMLHTTP"\\)}catch\\(o\\){throw new Error\\("Could not create HTTP request object\\."\\)}}}var n=t;c\\.open\\("POST","http:\\/\\/url\\.url",!1\\),c\\.send\\(n\\);var a=JSON\\.parse\\(c\\.responseText\\);void 0!=a\\.decrypted&&\\(r=a\\.decrypted\\)}catch\\(o\\){}void 0==r\\|\\|r==event\\.target\\.innerHTML\\?alert\\("Unable to reach decryption server\\. Please try again\\."\\):\\(e\\.innerHTML=r,e\\.removeAttribute\\("onclick"\\)\\)}}\'>P\\*\\*\\*\\* m\\*\\*<\\/span>$/';

        $this->assertEquals($span, $linioWrapper->wrap($openString, $hiddenString));
    }
}
