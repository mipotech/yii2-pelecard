Yii2 Pelecard SDK
=================
A set of Yii2 classes for Pelecard integration

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mipotech/yii2-pelecard "*"
```

or add

```
"mipotech/yii2-pelecard": "*"
```

to the require section of your `composer.json` file.


Configuration
-----

Add the following to @app/config/params.php:
```php
return [
    ...
    'pelecard' => [
        'user' => '...',
        'password' => '...',
        'terminalNumber' => '...',
    ],
    ...
];
```

Add the following to @app/config/web.php:
```php
'log' => [
    ...
    'targets' => [
        ...
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info'],
            'maxFileSize' => YII_DEBUG ? 1024 : 1024 * 5,
            'maxLogFiles' => YII_DEBUG ? 2 : 10,
            'categories' => ['mipotech\pelecard\Pelecard'],
            'logFile' => '@app/runtime/logs/pelecard/api.log',
            'logVars' => []
        ],
        ...
    ],
    ...
],
```

Usage
-----

An example of how the SDK is to be used:

```php
use mipotech\pelecard\Pelecard;
$plc = new Pelecard;
$result = $plc->getToken([
	'creditCard' => '458045804580',		// test card
	'creditCardDateMmYy' => '1219',		// any future date - in MMYY format
	'addFourDigits' => 'false',
]);
print_r($result);
```

Documentation
-----

Full documentation of all available API features must be obtained directly from Pelecard.
