<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Stripper;

// This class isn't necessarily meant for usage. Rather, just to show the other side of the ApiDecryptionDecorator.
use Exception;

class ApiDecryptionStripper
{
    /**
     * @var string
     */
    private $encryptionKey;

    /**
     * @var
     */
    private $encryptionMethod;

    public function __construct(
        string $encryptionKey,
        string $encryptionMethod
    ) {
        $this->encryptionKey = $encryptionKey;
        $this->encryptionMethod = $encryptionMethod;
    }

    public function unwrap(string $encryptedString): string
    {
        return $this->decrypt($encryptedString);
    }

    /**
     * @throws Exception
     */
    private function decrypt(string $encrypted): string
    {
        $encrypted = base64_decode($encrypted);

        $ivSize = openssl_cipher_iv_length($this->encryptionMethod);

        $iv = mb_substr($encrypted, 0, $ivSize, '8bit');

        $cipherText = mb_substr($encrypted, $ivSize, null, '8bit');

        $openString = openssl_decrypt(
            $cipherText,
            $this->encryptionMethod,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        if (!$openString) {
            throw new Exception('Unable to decrypt. Please check the encryption key and method and try again.');
        }

        return $openString;
    }
}
