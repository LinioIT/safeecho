safeecho
===
#Purpose
Replacement function for echo/print. It will take the string, hide it and then wrap the new hidden string with whatever wrapper is specified.

`echo John Smith` will print `John Smith`

Out-of-the-box
`safeecho('John Smith')` will print `J*** S****`

With a configuration file
`safeecho('John Smith')` can print 
```<span style="cursor: pointer;" onmouseout="this.innerHTML='J*** S****'" onmouseover="this.innerHTML='John Smith'">J*** S****</span>```

#Installation
The supported way of installing safeecho is via Composer.
`composer require linio/safeecho`

##Autoload function
In the `composer.json` file, add or append to the "autoload" field,
```
"autoload": {
    "files": [
        "vendor/linio/safeecho/src/safeecho.php"
    ]
}
```

##Configure safeecho Output
To override the default configuration of `safeecho`, you will need a configuration file.

Accepted file names are:
`safeecho.ini`
`safeecho.json`
`safeecho.php`
`safeecho.xml`
`safeecho.yaml`
`safeecho.yml`

Configuration files are searched for in the above order. The first configuration file found, is the configuration that is used.

The recommended location for the configuration is the project root directory.

###Example YML Configurations

`safeecho.yml`
```
decorator: Linio\SafeEcho\Decorator\MouseHoverDecorator
```

If you want to change the 'hideChar'

`safeecho.yml`
```
decorator: Linio\SafeEcho\Decorator\MouseHoverDecorator
hideChar: '~'
```

`safeecho('John Smith')` will now print 
```<span style="cursor: pointer;" onmouseout="this.innerHTML='J~~~ S~~~~'" onmouseover="this.innerHTML='John Smith'">J~~~ S~~~~</span>```

To use your own custom Decorator:
* `YourCustomDecorator` must extend `SafeEchoDecorator`

`safeecho.yml`
```
decorator:
    class: \Path\To\YourCustomDecorator
    arguments:
        arg1: arg1Value
        arg2: arg2Value
```

Please see [safeecho Configuration File](CONFIG.md) for configuration file examples.

#Testing
```
phpunit
```

#License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
