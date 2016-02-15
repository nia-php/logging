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
 * Logger implementation which uses a file.
 */
class FileSystemLogger implements LoggerInterface
{

    /**
     * Path to log file.
     *
     * @var string
     */
    private $file = null;

    /**
     * Constructor.
     *
     * @param string $file
     *            Path to log file. File and directory will be created if they not exist.
     * @throws InvalidArgumentException If the log directory does not exist.
     */
    public function __construct(string $file)
    {
        $directory = dirname($file);

        if (! is_dir($directory)) {
            throw new InvalidArgumentException(sprintf('Log directory "%s" does not exist.', $directory));
        }

        $this->file = $file;
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

        file_put_contents($this->file, $content, FILE_APPEND);

        return $this;
    }
}
