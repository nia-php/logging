<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Test\Nia\Logging;

use PHPUnit_Framework_TestCase;
use Nia\Logging\CompositeLogger;
use Nia\Logging\NullLogger;
use Nia\Logging\StreamLogger;

/**
 * Unit test for \Nia\Logging\CompositeLogger.
 */
class CompositeLoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Logging\CompositeLogger
     */
    public function testMethods()
    {
        $stream = fopen('php://temp', 'r+');

        $expectedLoggers = [
            new NullLogger(),
            new NullLogger()
        ];

        $logger = new CompositeLogger($expectedLoggers);
        $this->assertSame($expectedLoggers, $logger->getLoggers());

        $expectedLoggers[] = new StreamLogger($stream);
        $expectedLoggers[] = new NullLogger();

        $logger->addLogger($expectedLoggers[2]); // stream logger
        $logger->addLogger($expectedLoggers[3]); // null logger

        $this->assertSame($expectedLoggers, $logger->getLoggers());

        $logger->log('hello foo', [
            'foo' => 'bar',
            'bar' => [
                'foo',
                'bar',
                'baz'
            ]
        ]);
        $logger->log('foo baz', []);

        $expected = <<<EOL
[0000-00-00 00:00:00] hello foo
array(2) {
  ["foo"]=>
  string(3) "bar"
  ["bar"]=>
  array(3) {
    [0]=>
    string(3) "foo"
    [1]=>
    string(3) "bar"
    [2]=>
    string(3) "baz"
  }
}
[0000-00-00 00:00:00] foo baz

EOL;

        // replace date and time
        rewind($stream);
        $actual = stream_get_contents($stream);
        $actual = preg_replace('/^(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/m', '[0000-00-00 00:00:00]', $actual);

        $this->assertSame($expected, $actual);

        fclose($stream);
    }
}
