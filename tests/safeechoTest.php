<?php

declare(strict_types=1);

namespace Linio\SafeEcho;

use Linio\SafeEcho\Decorator\MouseHoverDecorator;
use Linio\SafeEcho\Entity\Customer;
use PHPUnit\Framework\TestCase;

class safeechoTest extends TestCase
{
    public function testObjectIsReturned()
    {
        $customer = new Customer(987654321, 'a sentence 4 you!');

        $this->assertEquals($customer, safeecho($customer, null, true));
    }

    public function testArrayIsReturned()
    {
        $array = ['thing1' => 'pinky', 'thing2' => 'brain'];

        $this->assertEquals($array, safeecho($array, null, true));
    }

    public function testObjectIsDumped()
    {
        $customer = new Customer(987654321, 'a sentence 4 you!');

        $this->expectOutputString(var_export($customer, true));

        safeecho($customer);
    }

    public function testArrayIsDumped()
    {
        $array = ['thing1' => 'pinky', 'thing2' => 'brain'];

        $this->expectOutputString(var_export($array, true));

        safeecho($array);
    }

    public function testStringIsReturned()
    {
        $string = 'Print me!';
        $hiddenString = 'P**** m**';

        $this->assertEquals($hiddenString, safeecho($string, null, true));
    }

    public function testStringIsDumped()
    {
        $string = 'Print me!';
        $hiddenString = 'P**** m**';

        $this->expectOutputString($hiddenString);

        safeecho($string);
    }

    public function testIntegerIsReturned()
    {
        $string = 987654321;
        $hiddenString = '9********';

        $this->assertEquals($hiddenString, safeecho($string, null, true));
    }

    public function testIntegerIsDumped()
    {
        $string = 987654321;
        $hiddenString = '9********';

        $this->expectOutputString($hiddenString);

        safeecho($string);
    }

    public function testFloatIsReturned()
    {
        $string = 1.2;
        $hiddenString = '1**';

        $this->assertEquals($hiddenString, safeecho($string, null, true));
    }

    public function testFloatIsDumped()
    {
        $string = 1.2;
        $hiddenString = '1**';

        $this->expectOutputString($hiddenString);

        safeecho($string);
    }

    public function testOutputWithConfigFile()
    {
        $config = json_encode(
            [
                'decorator' => MouseHoverDecorator::class,
                'hideChar' => '~',
            ]
        );

        file_put_contents(
            __DIR__ . '/../safeecho.json',
            $config
        );

        $string = 'Print me!';
        $hiddenString = '<span style="cursor: pointer;" onmouseout="this.innerHTML=\'P~~~~ m~~\'" onmouseover="this.innerHTML=\'Print me!\'">P~~~~ m~~</span>';

        $this->expectOutputString($hiddenString);

        safeecho($string);

        unlink(__DIR__ . '/../safeecho.json');
    }

    public function testReturnWithConfigFile()
    {
        $config = json_encode(
            [
                'decorator' => MouseHoverDecorator::class,
                'hideChar' => '&',
            ]
        );

        file_put_contents(
            __DIR__ . '/../safeecho.json',
            $config
        );

        $string = 'Print me!';
        $hiddenString = '<span style="cursor: pointer;" onmouseout="this.innerHTML=\'P&&&& m&&\'" onmouseover="this.innerHTML=\'Print me!\'">P&&&& m&&</span>';

        $this->assertEquals($hiddenString, safeecho($string, null, true));

        unlink(__DIR__ . '/../safeecho.json');
    }
}
