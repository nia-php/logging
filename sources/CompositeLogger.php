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
 * Composite logger, used to combine loggers.
 */
class CompositeLogger implements CompositeLoggerInterface
{

    /**
     * List with assigned loggers.
     *
     * @var LoggerInterface[]
     */
    private $loggers = [];

    /**
     * Constructor.
     *
     * @param LoggerInterface[] $loggers
     *            List with loggers to add.
     */
    public function __construct(array $loggers)
    {
        foreach ($loggers as $logger) {
            $this->addLogger($logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Logging\LoggerInterface::log($message, $context)
     */
    public function log(string $message, array $context): LoggerInterface
    {
        foreach ($this->loggers as $logger) {
            $logger->log($message, $context);
        }

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Logging\CompositeLoggerInterface::addLogger($logger)
     */
    public function addLogger(LoggerInterface $logger): CompositeLoggerInterface
    {
        $this->loggers[] = $logger;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Logging\CompositeLoggerInterface::getLoggers()
     */
    public function getLoggers(): array
    {
        return $this->loggers;
    }
}
