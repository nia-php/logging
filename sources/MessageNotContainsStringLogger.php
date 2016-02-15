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
 * Ignores a decorated logger if the message contains a specific string.
 */
class MessageNotContainsStringLogger implements LoggerInterface
{

    /**
     * The needle to search for in message text.
     *
     * @var string
     */
    private $needle = null;

    /**
     * Decorated logger.
     *
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * Constructor.
     *
     * @param string $needle
     *            The needle to search for in message text.
     * @param LoggerInterface $logger
     *            The decorated logger.
     */
    public function __construct(string $needle, LoggerInterface $logger)
    {
        $this->needle = $needle;
        $this->logger = $logger;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Logging\LoggerInterface::log($message, $context)
     */
    public function log(string $message, array $context): LoggerInterface
    {
        if (mb_strpos($message, $this->needle) === false) {
            $this->logger->log($message, $context);
        }

        return $this;
    }
}
