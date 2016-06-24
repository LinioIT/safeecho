<?php

declare(strict_types=1);

namespace Linio\SafeEcho\tests\Decorator;

use Linio\SafeEcho\Decorator\ApiDecryptionDecorator;
use PHPUnit\Framework\TestCase;

class ApiDecryptionDecoratorTest extends TestCase
{
    public function testWrap()
    {
        $linioWrapper = new ApiDecryptionDecorator('http://url.url', 'NotSoSecretEncryptionKey');

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';

        $postData['decrypt'] = 'qwertyuiopasdfghjklzxcvbnm';

        $span = '/^<span style="cursor: pointer;" onclick=\'decrypt\\(this, "%s"\\); function decrypt\\(e,t\\){var r=e\\.innerHTML;try{var c;try{c=new XMLHttpRequest}catch\\(n\\){try{c=new ActiveXObject\\("Msxml2\\.XMLHTTP"\\)}catch\\(n\\){try{c=new ActiveXObject\\("Microsoft\\.XMLHTTP"\\)}catch\\(n\\){throw new Error\\("Could not create HTTP request object\\."\\)}}}c\\.open\\("POST","http:\\/\\/url\\.url",!1\\),c\\.send\\(t\\);var o=JSON\\.parse\\(c\\.responseText\\);void 0!=o\\.decrypted?r=o\\.decrypted:\\(console\\.log\\(c\\.responseText\\),console\\.log\\(o\\)\\)}catch\\(n\\){}void 0==r||r==e\\.innerHTML?alert\\("Unable to reach decryption server\\. Please try again\\."\\):\\(e\\.innerHTML=r,e\\.removeAttribute\\("onclick"\\)\\)}}\'>P\\*\\*\\*\\* m\\*\\*<\\/span>$/';

        $span = sprintf($span, str_replace('qwertyuiopasdfghjklzxcvbnm', '[\S]+', json_encode($postData)));

        $this->assertRegExp($span, $linioWrapper->wrap($openString, $hiddenString));
    }

    public function testWrapWithData()
    {
        $linioWrapper = new ApiDecryptionDecorator('http://url.url', 'NotSoSecretEncryptionKey');

        $openString = 'Print me!';

        $hiddenString = 'P**** m**';

        $data = ['class' => 'customer', 'propertyName' => 'name', 'id' => 987654321];

        $postData['decrypt'] = 'qwertyuiopasdfghjklzxcvbnm';

        $postData['data'] = $data;

        $span = '/^<span style="cursor: pointer;" onclick=\'decrypt\\(this, "%s"\\); function decrypt\\(e,t\\){var r=e\\.innerHTML;try{var c;try{c=new XMLHttpRequest}catch\\(n\\){try{c=new ActiveXObject\\("Msxml2\\.XMLHTTP"\\)}catch\\(n\\){try{c=new ActiveXObject\\("Microsoft\\.XMLHTTP"\\)}catch\\(n\\){throw new Error\\("Could not create HTTP request object\\."\\)}}}c\\.open\\("POST","http:\\/\\/url\\.url",!1\\),c\\.send\\(t\\);var o=JSON\\.parse\\(c\\.responseText\\);void 0!=o\\.decrypted?r=o\\.decrypted:\\(console\\.log\\(c\\.responseText\\),console\\.log\\(o\\)\\)}catch\\(n\\){}void 0==r||r==e\\.innerHTML?alert\\("Unable to reach decryption server\\. Please try again\\."\\):\\(e\\.innerHTML=r,e\\.removeAttribute\\("onclick"\\)\\)}}\'>P\\*\\*\\*\\* m\\*\\*<\\/span>$/';

        $span = sprintf($span, str_replace('qwertyuiopasdfghjklzxcvbnm', '[\S]+', json_encode($postData)));

        $this->assertRegExp($span, $linioWrapper->wrap($openString, $hiddenString, $data));
    }
}
