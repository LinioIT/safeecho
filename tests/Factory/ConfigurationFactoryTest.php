<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Factory;

use Linio\SafeEcho\Decorator\NoWrapDecorator;
use PHPUnit\Framework\TestCase;

class ConfigurationFactoryTest extends TestCase
{
    public function testCreatesDefaultConfiguration(): void
    {
        $configuration = ConfigurationFactory::create();

        $this->assertInstanceOf(SafeEchoDefaultConfig::class, $configuration);
        $this->assertEquals(NoWrapDecorator::class, $configuration->get('decorator'));
        $this->assertEquals('*', $configuration->get('hideChar'));
    }

    //TODO: possible? mock all safeecho.XXX
    // make sure they are pulled in order
    //  - (first one found is used, in order of 'ini', 'json', 'php', 'xml', 'yaml', 'yml')
    // Check the decorator and hideChar returned
    // Check one that sets the decorator to an array.
}
