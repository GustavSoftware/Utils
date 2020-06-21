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
 * This class logs errors and writes them to standard output.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class PrintLogger extends ALogger
{
    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = []): void
    {
        if(!\in_array($level, self::$_levels)) {
            throw new InvalidArgumentException("invalid log level {$level}");
        }
        
        $addMessage = "<strong>" . \time() . " - {$level}</strong>: " .
            $this->_interpolate($message, $context) . "<br />";
        
        if(isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $addMessage .= "<em>Exception</em>: " . \get_class($context['exception']) .
                " (Code: {$context['exception']->getCode()}) " .
                $context['exception']->getMessage() . "<br />" .
                "Trace: " . $context['exception']->getTraceAsString() . "<br />";
        }
        
        echo "<div class\"log_message log_{$level}\">{$addMessage}</div>";
    }
}