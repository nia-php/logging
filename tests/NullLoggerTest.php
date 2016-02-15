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
use Nia\Logging\NullLogger;

/**
 * Unit test for \Nia\Logging\NullLogger.
 */
class NullLoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Logging\NullLogger::log
     */
    public function testLog()
    {
        $logger = new NullLogger();

        $this->assertSame($logger, $logger->log('foobar', []));
    }
}
