<?php

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
    private $encryptionAlgorithm;

    /**
     * @var
     */
    private $encryptionMode;

    /**
     * @var string
     */
    private $decryptionServerUri;

    /**
     * @param string $decryptionServerUri
     * @param string $encryptionKey
     * @param $encryptionAlgorithm
     * @param $encryptionMode
     */
    public function __construct(
        $decryptionServerUri,
        $encryptionKey,
        $encryptionAlgorithm,
        $encryptionMode
    ) {
        $this->encryptionKey = $encryptionKey;
        $this->encryptionAlgorithm = $encryptionAlgorithm;
        $this->encryptionMode = $encryptionMode;
        $this->decryptionServerUri = $decryptionServerUri;
    }

    /**
     * Sets the wrapped hiddenString for safe output.
     *
     * @param string $openString
     * @param string $hiddenString
     * @param null $data
     *
     * @return string
     */
    public function wrap($openString, $hiddenString, $data = null)
    {
        $postData['decrypt'] = $this->encrypt(
            $openString,
            $this->encryptionKey,
            $this->encryptionAlgorithm,
            $this->encryptionMode
        );

        if (!is_null($data)) {
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

    /**
     * @param string $word
     * @param string $encryptionKey
     * @param string $encryptionAlgorithm
     * @param string $encryptionMode
     *
     * @return string
     */
    private function encrypt(
         $word,
         $encryptionKey,
         $encryptionAlgorithm,
         $encryptionMode
    ) {
        $ivSize = mcrypt_get_iv_size($encryptionAlgorithm, $encryptionMode);

        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

        $cipherText = mcrypt_encrypt($encryptionAlgorithm, $encryptionKey, $word, $encryptionMode, $iv);

        return base64_encode($iv . $cipherText);
    }
}
