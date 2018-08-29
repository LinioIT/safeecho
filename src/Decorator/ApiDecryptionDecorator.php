<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Decorator;

class ApiDecryptionDecorator extends SafeEchoDecorator
{
    /**
     * @var string
     */
    private $encryptionKey;

    /**
     * @var
     */
    private $encryptionMethod;

    /**
     * @var string
     */
    private $decryptionServerUri;

    public function __construct(
        string $decryptionServerUri,
        string $encryptionKey,
        string $encryptionMethod
    ) {
        $this->encryptionKey = $encryptionKey;
        $this->encryptionMethod = $encryptionMethod;
        $this->decryptionServerUri = $decryptionServerUri;
    }

    /**
     * Sets the wrapped hiddenString for safe output.
     */
    public function wrap(string $openString, string $hiddenString, $data = null): string
    {
        $postData['decrypt'] = $this->encrypt($openString);

        if ($data !== null) {
            $postData['data'] = $data;
        }

        $functionName = 'decrypt';

        // original javascript function.
        /*
        function decrypt(target, postData) {
            var decrypted = target.innerHTML;
            try {
                var request;
                try {
                    request = new XMLHttpRequest();
                } catch (error) {
                    try {
                        request = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (error) {
                        try {
                            request = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (error) {
                            throw new Error("Could not create HTTP request object.");
                        }
                    }
                }
                request.open("POST", "%s", false);
                request.send(postData);
                var response = JSON.parse(request.responseText);
                if (response["decrypted"] != undefined) {
                    decrypted = response["decrypted"];
                } else {
                    console.log(request.responseText);
                    console.log(response);
                }
            } catch (error) {}
            if (decrypted == undefined || decrypted == target.innerHTML) {
                alert("Unable to reach decryption server. Please try again.");
            } else {
                target.innerHTML = decrypted;
                target.removeAttribute("onclick");
            }
        }
        */
        $jsFunction = sprintf(
            //minified javascript function
            'function %s(e,t){var r=e.innerHTML;try{var c;try{c=new XMLHttpRequest}catch(n){try{c=new ActiveXObject("Msxml2.XMLHTTP")}catch(n){try{c=new ActiveXObject("Microsoft.XMLHTTP")}catch(n){throw new Error("Could not create HTTP request object.")}}}c.open("POST","%s",!1),c.send(t);var o=JSON.parse(c.responseText);void 0!=o.decrypted?r=o.decrypted:(console.log(c.responseText),console.log(o))}catch(n){}void 0==r||r==e.innerHTML?alert("Unable to reach decryption server. Please try again."):(e.innerHTML=r,e.removeAttribute("onclick"))}',
            $functionName,
            $this->decryptionServerUri
        );

        $span = '<span style="cursor: pointer;" onclick=\'%s(this, "%s"); %s\'>%s</span >';

        return sprintf(
            $span,
            $functionName,
            str_replace('"', '\"', json_encode($postData)),
            $jsFunction,
            $hiddenString
        );
    }

    private function encrypt(string $openString): string
    {
        $ivSize = openssl_cipher_iv_length($this->encryptionMethod);

        $iv = openssl_random_pseudo_bytes($ivSize);

        $cipherText = openssl_encrypt(
            $openString,
            $this->encryptionMethod,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        return base64_encode($iv . $cipherText);
    }
}
