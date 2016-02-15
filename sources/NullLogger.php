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
namespace Nia\Logging;

/**
 * Null object logger implementation. Logs nothing and can be used to disable logging.
 */
class NullLogger implements LoggerInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Logging\LoggerInterface::log($message, $context)
     */
    public function log(string $message, array $context): LoggerInterface
    {
        return $this;
    }
}
