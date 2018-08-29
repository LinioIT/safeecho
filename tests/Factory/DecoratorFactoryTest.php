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

    public function testExceptionWhenNotSafeEchoDecorator(): void
    {
        $this->expectException(\Linio\SafeEcho\Exception\InvalidConfigurationFileException::class);

        $decoratorConfiguration = Exception::class;
        DecoratorFactory::create($decoratorConfiguration);
    }

    public function testExceptionOnNull(): void
    {
        $this->expectException(\Linio\SafeEcho\Exception\InvalidConfigurationFileException::class);
        $this->expectExceptionMessage('Cannot configure decorator.');

        DecoratorFactory::create(null);
    }

    public function testExceptionOnClassDoesNotExistFromString(): void
    {
        $this->expectException(\Linio\SafeEcho\Exception\InvalidConfigurationFileException::class);

        $decoratorConfiguration = 'Path\Does\Not\Exist';
        DecoratorFactory::create($decoratorConfiguration);
    }

    public function testExceptionOnClassDoesNotExistFromArray(): void
    {
        $this->expectException(\Linio\SafeEcho\Exception\InvalidConfigurationFileException::class);

        $decoratorConfiguration = [
            'class' => 'Path\Does\Not\Exist',
        ];
        DecoratorFactory::create($decoratorConfiguration);
    }

    public function testExceptionOnEmptyArray(): void
    {
        $this->expectException(\Linio\SafeEcho\Exception\InvalidConfigurationFileException::class);

        DecoratorFactory::create([]);
    }
}
