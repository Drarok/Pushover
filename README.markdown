# About

Pushover makes it easy to get real-time notifications on your Android device, iPhone, iPad, and Desktop.

This simple PHP library allows you to utilise Pushover from your PHP code.

## Features

* Supports full API feature set (including notification priority).
* Requires only curl extension.
* PSR-2 standard adherence.

## Requirements

* PHP ~5.3
* curl extension

## Usage

At its simplest, you create a connection, and pass Notification objects and the user token:

```php
$pushover = new Zerifas\Pushover\Connection($applicationToken);
$notification = new Zerifas\Pushover\Notification('Hello, world!');
$success = $pushover->notifyUser($notification, $userToken);
```

You may also want to omit the user token passed to notifyUser if you're only delivering to one user:

```php
$pushover = new Zerifas\Pushover\Connection($applicationToken, $userToken);
$notification = new Zerifas\Pushover\Notification('Hello, world!');
$success = $pushover->notifyUser($notification);
```

The `Notification` class supports all the options defined in the [API][api], and a fluent interface.

```php
$pushover = new Zerifas\Pushover\Connection($applicationToken, $userToken);

$notification = new Zerifas\Pushover\Notification('Hello, world!');
$notification->setTitle('Title')
    ->setUrl('http://www.pushover.net/')
    ->setUrlTitle('Pushover')
    ->setPriority(Zerifas\Pushover\Notification::PRIORITY_QUIET)
    ->setTimestamp(time())
    ->setSound('cosmic')
;
$success = $pushover->notifyUser($notification);
```

You can also get the status code and response as an array if required:

```php
$pushover = new Zerifas\Pushover\Connection($applicationToken, $userToken);
$notification = new Zerifas\Pushover\Notification('Hello, world!');
$success = $pushover->notifyUser($notification);
$statusCode = $pushover->getLastStatusCode();
$response = $pushover->getLastResponse();
$requestId = $response['request'];
$errors = $response['errors'];
```

[api]: https://pushover.net/api
