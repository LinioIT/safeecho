safeecho Configuration File
===
#INI
####safeecho.ini
Example 1:
```
decorator = Linio\SafeEcho\Decorator\MouseHoverDecorator
hideChar = a
```

Example 2:
```
hideChar = b

[decorator]
class = Linio\SafeEcho\Decorator\ApiDecryptionDecorator
arguments[decryptionServerUri] = 'http://safeecho.api'
arguments[encryptionKey] = NotSoSecretEncryptionKey
arguments[encryptionAlgorithm] = rijndael-128
arguments[encryptionMode] = cbc
```

#JSON
####safeecho.json
Example 1:
```
{
    "decorator": "Linio\\SafeEcho\\Decorator\\MouseHoverDecorator",
    "hideChar": "c"
}
```

Example 2:
```
{
    "decorator": {
        "class": "Linio\\SafeEcho\\Decorator\\ApiDecryptionDecorator",
        "arguments": {
            "decryptionServerUri": "http://safeecho.api",
            "encryptionKey": "NotSoSecretEncryptionKey",
            "encryptionAlgorithm": "rijndael-128",
            "encryptionMode": "cbc"
        }
    },
    "hideChar": "d"
}
```

#PHP
####safeecho.php
Example 1:
```
<?php
return [
    'decorator' => 'Linio\SafeEcho\Decorator\MouseHoverDecorator',
    'hideChar' => 'e',
];
```

Example 2:
```
<?php
return [
    'decorator' => [
        'class' => 'Linio\SafeEcho\Decorator\ApiDecryptionDecorator',
        'arguments' => [
            'decryptionServerUri' => 'http://safeecho.api',
            'encryptionKey' => 'NotSoSecretEncryptionKey',
            'encryptionAlgorithm' => 'rijndael-128',
            'encryptionMode' => 'cbc',
        ],
    ],
    'hideChar' => 'f',
];

```

#XML
####safeecho.xml
Example 1:
```
<?xml version="1.0" encoding="UTF-8"?>
<config>
    <decorator>Linio\SafeEcho\Decorator\MouseHoverDecorator</decorator>
    <hideChar>g</hideChar>
</config>
```

Example 2:
```
<?xml version="1.0" encoding="UTF-8"?>
<config>
    <decorator>
        <class>Linio\SafeEcho\Decorator\ApiDecryptionDecorator</class>
        <arguments>
            <decryptionServerUri>http://safeecho.api</decryptionServerUri>
            <encryptionKey>NotSoSecretEncryptionKey</encryptionKey>
            <encryptionAlgorithm>rijndael-128</encryptionAlgorithm>
            <encryptionMode>cbc</encryptionMode>
        </arguments>
    </decorator>
    <hideChar>h</hideChar>
</config>
```

#YAML or YML
####safeecho.yaml or safeecho.yml
Example 1:
```
decorator: Linio\SafeEcho\Decorator\MouseHoverDecorator
hideChar: 'i'
```

Example 2:
```
decorator:
    class: Linio\SafeEcho\Decorator\ApiDecryptionDecorator
    arguments:
        decryptionServerUri: http://safeecho.api
        encryptionKey: NotSoSecretEncryptionKey
        encryptionAlgorithm: tripledes
        encryptionMode: cbc
hideChar: 'j'
```
