Yii2 SMS extension
==================
[![Latest Stable Version](https://poser.pugx.org/omnilight/yii2-sms/v/stable)](https://packagist.org/packages/omnilight/yii2-sms)
[![Total Downloads](https://poser.pugx.org/omnilight/yii2-sms/downloads)](https://packagist.org/packages/omnilight/yii2-sms)
[![License](https://poser.pugx.org/omnilight/yii2-sms/license)](https://packagist.org/packages/omnilight/yii2-sms)

This extension is designed to send sms messages through different services and protocols.

* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)

## Installation
```bash
composer require omnilight/yii2-sms
```

## Configuration
```php
//...
'components'    => [
//...
    'sms'   =>  [
        'class' => 'omnilight\sms\Sms',
        'services'  => [
            // File
            'file'  => [
                'class' => 'omnilight\sms\services\File'
            ],
            // smsonline.ru
            'smsonline' =>  [
                'class'     =>  'omnilight\sms\services\SmsOnline',
                'login'     => 'your login',
                'password'  => 'your password'   
            ],
            // see more src/services
        ]
    ]
//...
],
//...
```

## Usage
```php
//...
Yii::$app->sms->send('phone number', 'Lily Was Here');
//...
```