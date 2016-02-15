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
use Nia\Logging\FileSystemLogger;

/**
 * Unit test for \Nia\Logging\FileSystemLogger.
 */
class FileSystemLoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Logging\FileSystemLogger::log
     */
    public function testLog()
    {
        $file = tempnam('/tmp', 'unittest-') . '.txt';

        $logger = new FileSystemLogger($file);
        $logger->log('foo bar', []);
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
[0000-00-00 00:00:00] foo bar
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
        $actual = file_get_contents($file);
        $actual = preg_replace('/^(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/m', '[0000-00-00 00:00:00]', $actual);

        unlink($file);

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \Nia\Logging\FileSystemLogger::log
     */
    public function testLogException()
    {
        $directory = tempnam('/tmp', 'unittest-');
        $file = $directory . '/log.txt';
        unlink($directory);

        $this->setExpectedException(\InvalidArgumentException::class, 'Log directory "' . $directory . '" does not exist.');

        new FileSystemLogger($file);
    }
}
