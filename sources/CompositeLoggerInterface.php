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
 * Interface for composite logger implementations.
 */
interface CompositeLoggerInterface extends LoggerInterface
{

    /**
     * Adds a logger to this composite logger.
     *
     * @param LoggerInterface $logger
     *            Logger to add.
     * @return CompositeLoggerInterface Reference to this instance.
     */
    public function addLogger(LoggerInterface $logger): CompositeLoggerInterface;

    /**
     * Returns a list with assigned loggers.
     *
     * @return LoggerInterface[] List with assigned loggers.
     */
    public function getLoggers(): array;
}
