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

use Gustav\Utils\GustavException;

/**
 * This class represents exceptions that occur while handling of mapping data.
 *
 * Possible error codes are:
 * 1 - Invalid implementation of logger interface.
 * 2 - Logger with the given name cannot be found.
 * 3 - Invalid file name of the file logger.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class LogException extends GustavException
{
    /**
     * The possible error codes.
     */
    const INVALID_IMPLEMENTATION = 1;
    const UNKNOWN_LOGGER = 2;
    const INVALID_FILENAME = 3;
    
    /**
     * Creates an exception if an invalid logger implementation was set in
     * configuration data.
     *
     * @param string $className
     *   The class name
     * @param \Exception|null $previous
     *   Previous exception
     * @return \Gustav\Utils\Log\LogException
     *   The exception
     */
    public static function invalidImplementation(
        string $className,
        \Exception $previous = null
    ): self {
        return new self(
            "class \"{$className}\" is not a logger",
            self::INVALID_IMPLEMENTATION,
            $previous
        );
    }
    
    /**
     * Creates an exception if the logger with the given name could not be found
     * by the log manager.
     *
     * @param string $name
     *   The logger's identifying name
     * @param \Exception|null $previous
     *   Previous exception
     * @return \Gustav\Utils\Log\LogException
     *   The exception
     */
    public static function unknownLogger(
        string $name,
        \Exception $previous = null
    ): self {
        return new self(
            "could not find logger \"{$name}\"",
            self::UNKNOWN_LOGGER,
            $previous
        );
    }
    
    /**
     * Creates an exception if an invalid file name was set in configuration of
     * a file logger.
     *
     * @param string $fileName
     *   The file name
     * @param \Exception|null $previous
     *   Previous exception
     * @return \Gustav\Utils\Log\LogException
     *   The exception
     */
    public static function invalidFileName(
        string $fileName,
        \Exception $previous = null
    ): self {
        return new self(
            "invalid log file \"{$fileName}\"",
            self::INVALID_FILENAME,
            $previous
        );
    }
}