<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Stripper;

/* This class isn't necessarily meant for usage. Rather, just to show the other side of the ApiDecryptionDecorator. */
class ApiDecryptionStripper
{
    /**
     * @var string
     */
    private $encryptionKey;

    /**
     * @var
     */
    private $encryptionAlgorithm;

    /**
     * @var
     */
    private $encryptionMode;

    /**
     * @param string $encryptionKey
     * @param $encryptionAlgorithm
     * @param $encryptionMode
     */
    public function __construct(
        string $encryptionKey,
        string $encryptionAlgorithm = MCRYPT_3DES,
        string $encryptionMode = MCRYPT_MODE_CBC
    ) {
        $this->encryptionKey = $encryptionKey;
        $this->encryptionAlgorithm = $encryptionAlgorithm;
        $this->encryptionMode = $encryptionMode;
    }

    /**
     * @param string $encryptedString
     *
     * @return string
     */
    public function unwrap(string $encryptedString): string
    {
        return $this->decrypt($encryptedString, $this->encryptionKey, $this->encryptionAlgorithm, $this->encryptionMode);
    }

    /**
     * @param string $encrypted
     * @param string $encryptionKey
     * @param string $encryptionAlgorithm
     * @param string $encryptionMode
     *
     * @return string
     */
    private function decrypt(
        string $encrypted,
        string $encryptionKey,
        string $encryptionAlgorithm = MCRYPT_3DES,
        string $encryptionMode = MCRYPT_MODE_CBC
    ): string {
        $ivSize = mcrypt_get_iv_size($encryptionAlgorithm, $encryptionMode);

        $cipherTextAndIv = base64_decode($encrypted);

        $cipherText = substr($cipherTextAndIv, $ivSize);

        $iv = substr($cipherTextAndIv, 0, $ivSize);

        return rtrim(mcrypt_decrypt($encryptionAlgorithm, $encryptionKey, $cipherText, $encryptionMode, $iv), "\0");
    }
}
