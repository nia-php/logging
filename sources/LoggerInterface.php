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
 * Interface for logger implementations.
 */
interface LoggerInterface
{

    /**
     * Logs a message with a context.
     *
     * @param string $message
     *            The message to log.
     * @param string[] $context
     *            The message context.
     * @return LoggerInterface Reference to this instance.
     */
    public function log(string $message, array $context): LoggerInterface;
}
