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
use Nia\Logging\MessageContainsStringLogger;
use Nia\Logging\StreamLogger;

/**
 * Unit test for \Nia\Logging\MessageContainsStringLogger.
 */
class MessageContainsStringLoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Logging\MessageContainsStringLogger::log
     */
    public function testLog()
    {
        $stream = fopen('php://temp', 'r+');

        $logger = new MessageContainsStringLogger('password', new StreamLogger($stream));
        $logger->log('i will not logged', []);
        $logger->log('but i, because the word "password" is in the message', []);

        rewind($stream);
        $actual = stream_get_contents($stream);
        fclose($stream);

        $expected = "[0000-00-00 00:00:00] but i, because the word \"password\" is in the message\n";

        // replace date and time
        $actual = preg_replace('/^(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/m', '[0000-00-00 00:00:00]', $actual);

        $this->assertSame($expected, $actual);
    }
}
