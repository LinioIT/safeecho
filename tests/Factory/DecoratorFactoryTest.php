<?php

declare(strict_types=1);

namespace Linio\SafeEcho\tests\Factory;

use Exception;
use Linio\SafeEcho\Decorator\ApiDecryptionDecorator;
use Linio\SafeEcho\Decorator\MouseHoverDecorator;
use Linio\SafeEcho\Decorator\SafeEchoDecorator;
use Linio\SafeEcho\Factory\DecoratorFactory;
use PHPUnit\Framework\TestCase;
use TypeError;

class DecoratorFactoryTest extends TestCase
{
    public function testCreatesDecoratorFromString()
    {
        $decoratorConfiguration = MouseHoverDecorator::class;
        $decorator = DecoratorFactory::create($decoratorConfiguration);

        $this->assertInstanceOf(SafeEchoDecorator::class, $decorator);
        $this->assertInstanceOf(MouseHoverDecorator::class, $decorator);
    }

    public function testCreatesDecoratorFromArrayWithNoArguments()
    {
        $decoratorConfiguration = [
            'class' => MouseHoverDecorator::class,
        ];
        $decorator = DecoratorFactory::create($decoratorConfiguration);

        $this->assertInstanceOf(SafeEchoDecorator::class, $decorator);
        $this->assertInstanceOf(MouseHoverDecorator::class, $decorator);
    }

    public function testCreatesDecoratorFromArray()
    {
        $decoratorConfiguration = [
            'class' => ApiDecryptionDecorator::class,
            'arguments' => [
                'decryptionServerUri' => 'http://url.url',
                'encryptionKey' => 'IamAnonSecureEncryptionKey',
            ],
        ];
        $decorator = DecoratorFactory::create($decoratorConfiguration);

        $this->assertInstanceOf(SafeEchoDecorator::class, $decorator);
        $this->assertInstanceOf(ApiDecryptionDecorator::class, $decorator);
    }

    /**
     * @expectedException TypeError
     */
    public function testExceptionWhenNotSafeEchoDecorator()
    {
        $decoratorConfiguration = Exception::class;
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     * @expectedExceptionMessage Cannot configure decorator.
     */
    public function testExceptionOnNull()
    {
        DecoratorFactory::create(null);
    }

    /**
     * @expectedException TypeError
     */
    public function testExceptionOnClassDoesNotExistFromString()
    {
        $decoratorConfiguration = 'Path\Does\Not\Exist';
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException TypeError
     */
    public function testExceptionOnClassDoesNotExistFromArray()
    {
        $decoratorConfiguration = [
            'class' => 'Path\Does\Not\Exist',
        ];
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException TypeError
     */
    public function testExceptionOnEmptyArray()
    {
        DecoratorFactory::create([]);
    }
}
