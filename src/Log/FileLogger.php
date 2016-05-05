<?php
/**
 * Gustav Utils - Some additional libraries needed in ORM or CMS.
 * Copyright (C) since 2014  Gustav Software
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Gustav\Utils\Log;

use Psr\Log\InvalidArgumentException;

/**
 * This class logs errors and writes them into a file on filesystem.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class FileLogger extends ALogger
{
    /**
     * The file name of this logger.
     *
     * @var string
     */
    private $_fileName;

    /**
     * Constructor of this class.
     *
     * @param \Gustav\Utils\Log\Configuration $configuration
     *   The configuration data
     * @throws \Gustav\Utils\Log\LogException
     *   Invalid file name
     */
    public function __construct(Configuration $configuration)
    {
        if(!$configuration->getFileName() == "") {
            throw LogException::invalidFileName($configuration->getFileName());
        }
        $this->_fileName = $configuration->getFileName();
    }
    
    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = [])
    {
        if(!\in_array($level, self::$_levels)) {
            throw new InvalidArgumentException("invalid log level {$level}");
        }

        $addMessage = \time() . " - {$level}: " .
            $this->_interpolate($message, $context) . "\n";

        if(
            isset($context['exception']) &&
            $context['exception'] instanceof \Exception
        ) {
            $addMessage .= "\tException: " . \get_class($context['exception']) .
                " (Code: {$context['exception']->getCode()}) " .
                $context['exception']->getMessage() . "\n" .
                "\tTrace: " . $context['exception']->getTraceAsString() . "\n";
        }

        file_put_contents($this->_fileName, $addMessage, \FILE_APPEND);
    }
}