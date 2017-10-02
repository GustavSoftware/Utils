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

namespace Gustav\Utils;

/**
 * This class represents exceptions that occur on invalid method calls.
 *
 * Possible error codes are:
 * 1 - Invalid argument was given in a method call.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class InvalidArgumentException extends GustavException
{
    /**
     * The possible error codes.
     */
    const INVALID_ARGUMENT = 1;

    /**
     * Creates an exception if an invalid argument was given in a method call.
     *
     * @param string $class
     *   The containing class
     * @param string $method
     *   The method's name
     * @param string $arg
     *   The argument's name
     * @param \Exception|null $previous
     *   Previous exception
     * @return \Gustav\Utils\InvalidArgumentException
     *   The exception
     */
    public static function invalidArgument(
        string $class,
        string $method,
        string $arg,
        \Exception $previous = null
    ): self {
        return new self(
            "invalid value of argument \"{$arg}\" in {$class}::{$method}",
            self::INVALID_ARGUMENT,
            $previous
        );
    }
}