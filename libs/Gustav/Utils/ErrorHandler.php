<?php

/*
 * Gustav Utils - Some additional libraries needed in ORM or CMS.
 * Copyright (C) 2014-2015  Gustav Software
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
 * This class handles unexpected errors and warnings on runtime.
 * 
 * @author  Chris Köcher <ckone@fieselschweif.de>
 * @link    http://gustav.fieselschweif.de
 * @package Gustav.Utils
 * @since   1.0
 */
class ErrorHandler {
    /**
     * The path, where the log files are saved.
     */
    const LOG_DIR = "log/";
    
    /**
     * Some data of the last occurred error or warning.
     *
     * @var       array
     * @staticvar
     */
    private static $_error = array();
    
    /**
     * This method will be called if an error on runtime occurred. The error
     * will be logged in log file. If the error is fatal, a friendly error
     * message will be output and the script will halt.
     *
     * @param  int    $number  The error code (as defined by PHP)
     * @param  string $message The error message
     * @param  string $file    The file in which the error occurred
     * @param  int    $line    The line of code in which the error occurred
     * @param  array  $context The context on error occurrence
     * @static
     */
    public static function setError($number, $message, $file = "", $line = 0,
            $context = array()) {
        if($file === "") {
            $debug = \debug_backtrace();
            $file = $debug[1]['file'];
            $line = $debug[1]['line'];
        }
        
        self::$_error = array(
            'number' => (int) $number,
            'message' => (string) $message,
            'file' => (string) $file,
            'line' => (int) $line,
            'context' => (array) $context
        );
        
        switch($number) {
            case \E_ERROR:
            case \E_PARSE:
            case \E_CORE_ERROR:
            case \E_COMPILE_ERROR:
            case \E_RECOVERABLE_ERROR:
            case \E_USER_ERROR:
                self::logError();
                self::printError();
                exit;
            default:
                self::logWarning();
        }
    }
    
    /**
     * This method will be called if a warning on runtime occurred. The warning
     * will only be logged in log file. The script doesn't halt afterwards and
     * no friendly message will appear in output.
     *
     * @param  string $message The error message
     * @param  string $file    The file in which the error occurred
     * @param  int    $line    The line of code in which the error occurred
     * @param  array  $context The context on error occurrence
     * @static
     */
    public static function setWarning($message, $file = "", $line = 0,
            $context = array()) {
        if($file === "") {
            $debug = \debug_backtrace(0, 2);
            $file = $debug[1]['file'];
            $line = $debug[1]['line'];
        }
        self::setError(\E_USER_WARNING, $message, $file, $line, $context);
    }
    
    /**
     * Adds a log entry in error log after occurrence of a fatal error.
     * 
     * @static
     */
    private static function logError() {
        echo self::$_error['message'] . "," . self::$_error['file'] . ","
                . self::$_error['line'] . \PHP_EOL;
/*        \error_log(self::$_error['message'] . "\n", 3, \Gustav\ROOT_DIR //TODO: update directory
                . self::LOG_DIR . "error.log"); //TODO: add friendly message...*/
    }
    
    /**
     * Adds a log entry in warning log after occurrence of a warning.
     * 
     * @static
     */
    private static function logWarning() {
        echo self::$_error['message'] . "," . self::$_error['file'] . ","
                . self::$_error['line'] . \PHP_EOL;
/*        \error_log(self::$_error['message'] . "," . self::$_error['file'] . ","
                . self::$_error['line'] . "\n", 3, \Gustav\ROOT_DIR //TODO: update directory
                . self::LOG_DIR . "warning.log"); //TODO: add friendly message...*/
    }
    
    /**
     * Prints a friendly message about that error on output. Please note that
     * the concrete error message will not appear in this message.
     * 
     * @static
     */
    private static function printError() {
        //TODO!!!
    }
}