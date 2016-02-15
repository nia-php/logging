# nia - Logging

Component for a simple and hierarchical logging of messages.

## Installation

Require this package with Composer.

```bash
	composer require nia/logging
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## Loggers
The component provides several loggers but you are able to write your own logger by implementing the `Nia\Logging\LoggerInterface` interface for a more specific use case.

| Logger | Description |
| --- | --- |
| `Nia\Logging\CompositeLogger` | Composite logger, used to combine loggers. |
| `Nia\Logging\FileSystemLogger` | Logger implementation which uses a file. |
| `Nia\Logging\MessageContainsStringLogger` | Executes a decorated logger if the message contains a specific string. |
| `Nia\Logging\MessageNotContainsStringLogger` | Ignores a decorated logger if the message contains a specific string. |
| `Nia\Logging\NullLogger` | Null object logger implementation. Logs nothing and can be used to disable logging. |
| `Nia\Logging\StreamLogger` | Logger implementation which uses a stream. |

## How to use
The following sample shows you how to use the logging component. Note that `EmailLogger` (contained in `nia/bridge-mailing-logging`) and `SmsLogger` are not contained in this component and are only named to show you a common use case.

```php
	// hierarchical logger structure.
	$logger = new CompositeLogger([
	    new FileSystemLogger(__DIR__ . '/data/log.txt'),
	    new StreamLogger($stream),
	    new MessageContainsStringLogger('waring', new CompositeLogger([
	        new EmailLogger(/* crash@my-company.tld */),
	        new MessageContainsStringLogger('critical', new CompositeLogger([
	            new EmailLogger(/* it@my-company.tld */),
	            new SmsLogger(/* 01234-head-of-development */)
	        ]))
	    ]))
	]);

	// if the log has to be disabled, just use the NullLogger implementation.
	if ($logDisabled) {
		$logger = new NullLogger();
	}

	// [...]

	// logged into /data/log.txt, $stream
	$logger->log('my first message.', []);

	// logged into /data/log.txt, $stream
	$logger->log('my second message.', []);

	// logged into /data/log.txt, $stream, crash@my-company.tld
	$logger->log('a warning occured.', []);

	// logged into /data/log.txt, $stream, crash@my-company.tld,
	//             it@my-company.tld, 01234-head-of-development
	$logger->log('a critical warning occured.', []);

	// logged into /data/log.txt, $stream
	$logger->log('this is critical.', []);

```
