<?php

declare(strict_types=1);

namespace Linio\SafeEcho\tests\Stripper;

use Linio\SafeEcho\Stripper\ApiDecryptionStripper;
use PHPUnit\Framework\TestCase;

class ApiDecryptionStripperTest extends TestCase
{
    public function testUnwrap()
    {
        $linioWrapper = new ApiDecryptionStripper('NotSoSecretEncryptionKey');

        $encryptionString = 'OwYjFosL3NR7T6/L2HUVuMw+D9g2zVZu';

        $returnString = 'Print me!';

        $this->assertStringMatchesFormat($returnString, $linioWrapper->unwrap($encryptionString));
    }
}
