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

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * This is a common interface for all our logger implementations.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
abstract class ALogger extends AbstractLogger
{
    /**
     * This array caches all the possible logging levels.
     *
     * @var string[]
     */
    protected static array $_levels = [
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::DEBUG,
        LogLevel::EMERGENCY,
        LogLevel::ERROR,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING
    ];
    
    /**
     * Interpolates context values into the message placeholders.
     *
     * @param string $message
     *   The containing message with placeholders
     * @param array $context
     *   The replacements in this message
     * @return string
     *   The interpolated message string
     */
    protected function _interpolate(string $message, array $context = []): string
    {
        //build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            if($key == "exception") {
                continue;
            }
            $replace['{' . $key . '}'] = $val;
        }
        
        //interpolate replacement values into the message and return
        return \strtr($message, $replace);
    }
}