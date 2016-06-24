<?php

declare(strict_types=1);

namespace Linio\SafeEcho\tests\Stripper;

use Linio\SafeEcho\Stripper\ApiDecryptionStripper;
use PHPUnit\Framework\TestCase;

class ApiDecryptionStripperTest extends TestCase
{
    public function testUnwrap()
    {
        $linioWrapper = new ApiDecryptionStripper('NotSoSecretEncryptionKey', MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        $encryptionString = '2KNiwlhjq3KpWpUjh5fWuSsLt1LmpTT6WLvRjgjDo7M=';

        $returnString = 'Print me!';

        $this->assertStringMatchesFormat($returnString, $linioWrapper->unwrap($encryptionString));
    }
}
