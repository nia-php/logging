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

use InvalidArgumentException;

/**
 * Logger implementation which uses a stream.
 */
class StreamLogger implements LoggerInterface
{

    /**
     * The used stream.
     *
     * @var mixed
     */
    private $stream = null;

    /**
     * Constructor.
     *
     * @param mixed $stream
     *            The used stream.
     * @throws InvalidArgumentException If the passed stream is not a resource.
     */
    public function __construct($stream)
    {
        if (! is_resource($stream)) {
            throw new \InvalidArgumentException('The passed stream is not a resource.');
        }

        $this->stream = $stream;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Logging\LoggerInterface::log($message, $context)
     */
    public function log(string $message, array $context): LoggerInterface
    {
        $content = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message);

        // add context only if the context is not empty.
        if (count($context) !== 0) {
            ob_start();
            var_dump($context);
            $content .= ob_get_clean();
        }

        fwrite($this->stream, $content);

        return $this;
    }
}
