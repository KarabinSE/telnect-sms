# Telnect SMS Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/karabinse/telnect-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/telnect-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/karabinse/telnect-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/telnect-sms)

This package makes it easy to send notifications using [TelnectSms](link to service) with Laravel 10.x. Tested on PHP 8.4 and PHP 8.5.

This package provides a Laravel notification channel for sending SMS messages via the [Telnect](https://telnect.com) API. It integrates with Laravel's notification system, allowing you to send SMS notifications by adding the `TelnectSms` channel to your notifiable classes.

## Contents

- [Installation](#installation)
	- [Setting up the TelnectSms service](#setting-up-the-TelnectSms-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation
```
composer require karabinse/telnect-sms --update-with-dependencies
```

### Setting up the TelnectSms service

You need to obtain an API key from Telnect. You can contact via [this form](https://telnect.com/homepage/contact-us/)

Add your Telnect API to `services.php`
```
<?php

return [

    // ...

    'telnect_sms' => [
        'api_key' => env('TELNECT_SMS_API_KEY'),
    ],

];
```
## Usage

Now you can use the channel in your via() method inside the notification:

```
<?php

use Karabin\TelnectSms\TelnectSmsChannel;
use Karabin\TelnectSms\TelnectSmsMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [SnsChannel::class];
    }

    public function toTelnectSms($notifiable)
    {
        return TelnectSmsMessage::create()
            ->body("Your account is created and ready to be used")
            ->sender('MyBusiness');
    }
}
```


## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email info@karabin.se instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Karabin AB](https://github.com/KarabinSE)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
