<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Stripper;

use PHPUnit\Framework\TestCase;

class ApiDecryptionStripperTest extends TestCase
{
    public function testUnwrap()
    {
        $encryptionKey = 'NotSoSecretEncryptionKey';
        $encryptionMethod = 'AES-256-CBC';
        $encryptionString = 'cgcWSy9t476XVthhq5CNYMZTLk/BBGDqH7Q2YjBFBAs=';

        $returnString = 'Print me!';

        $linioWrapper = new ApiDecryptionStripper($encryptionKey, $encryptionMethod);

        $this->assertStringMatchesFormat($returnString, $linioWrapper->unwrap($encryptionString));
    }
}
