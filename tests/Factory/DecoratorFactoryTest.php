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
    public function testCreatesDecoratorFromString(): void
    {
        $decoratorConfiguration = MouseHoverDecorator::class;
        $decorator = DecoratorFactory::create($decoratorConfiguration);

        $this->assertInstanceOf(SafeEchoDecorator::class, $decorator);
        $this->assertInstanceOf(MouseHoverDecorator::class, $decorator);
    }

    public function testCreatesDecoratorFromArrayWithNoArguments(): void
    {
        $decoratorConfiguration = [
            'class' => MouseHoverDecorator::class,
        ];
        $decorator = DecoratorFactory::create($decoratorConfiguration);

        $this->assertInstanceOf(SafeEchoDecorator::class, $decorator);
        $this->assertInstanceOf(MouseHoverDecorator::class, $decorator);
    }

    public function testCreatesDecoratorFromArray(): void
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
    public function testExceptionWhenNotSafeEchoDecorator(): void
    {
        $decoratorConfiguration = Exception::class;
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     * @expectedExceptionMessage Cannot configure decorator.
     */
    public function testExceptionOnNull(): void
    {
        DecoratorFactory::create(null);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     */
    public function testExceptionOnClassDoesNotExistFromString(): void
    {
        $decoratorConfiguration = 'Path\Does\Not\Exist';
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     */
    public function testExceptionOnClassDoesNotExistFromArray(): void
    {
        $decoratorConfiguration = [
            'class' => 'Path\Does\Not\Exist',
        ];
        DecoratorFactory::create($decoratorConfiguration);
    }

    /**
     * @expectedException \Linio\SafeEcho\Exception\InvalidConfigurationFileException
     */
    public function testExceptionOnEmptyArray(): void
    {
        DecoratorFactory::create([]);
    }
}
