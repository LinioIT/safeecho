<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Factory;

use Exception;
use Linio\SafeEcho\Decorator\ApiDecryptionDecorator;
use Linio\SafeEcho\Decorator\MouseHoverDecorator;
use Linio\SafeEcho\Decorator\SafeEchoDecorator;
use PHPUnit\Framework\TestCase;

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
                'encryptionMethod' => 'AES-256-CBC',
            ],
        ];
        $decorator = DecoratorFactory::create($decoratorConfiguration);

        $this->assertInstanceOf(SafeEchoDecorator::class, $decorator);
        $this->assertInstanceOf(ApiDecryptionDecorator::class, $decorator);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
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
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     */
    public function testExceptionOnClassDoesNotExistFromString()
    {
        $decoratorConfiguration = 'Path\Does\Not\Exist';
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     */
    public function testExceptionOnClassDoesNotExistFromArray()
    {
        $decoratorConfiguration = [
            'class' => 'Path\Does\Not\Exist',
        ];
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     */
    public function testExceptionOnEmptyArray()
    {
        DecoratorFactory::create([]);
    }
}
