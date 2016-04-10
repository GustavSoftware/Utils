<?php

/*
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

use Psr\Log\LoggerInterface;

/**
 * This class manages the creation and access to the logger classes.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class LogManager
{
    /**
     * All the opened loggers.
     * 
     * @var \Psr\Log\LoggerInterface[]
     */
    private static $_loggers = [];
    
    /**
     * A map of the logger identifiers to the used file names of the log files
     * (in case of FileLogger). This is needed to avoid race conditions on
     * writing into these files. So we just use one logger per file.
     * 
     * @var array
     */
    private static $_nameMap = [];
    
    /**
     * Creates a new logger with the help of the given configuration data. This
     * method has no effect, if another logger with the same identifier exists,
     * yet.
     * 
     * @param \Gustav\Utils\Log\Configuration $configuration
     *   The configuration of the logger to create here
     * @return \Psr\Log\LoggerInterface
     *   The new logger (resp. the logger with the same name, if it exists, yet)
     */
    public static function getLogger(Configuration $configuration): LoggerInterface
    {
        $identifier = $configuration->getIdentifier();
        if(isset(self::$_loggers[$identifier])) {
            return self::$_loggers[$identifier]; //just ignore the new configuration
        }
        switch($configuration->getImplementation()) {
            case FileLogger::class:
                $fileName = $configuration->getFileName();
                if(isset(self::$_nameMap[$fileName])) {
                    self::$_loggers[$identifier] =
                        self::$_loggers[self::$_nameMap[$fileName]];
                    break;
                }
                self::$_nameMap[$fileName] = $identifier;
                self::$_loggers[$identifier] = new FileLogger($configuration);
                break;
            default:
                $className = $configuration->getImplementation();
                self::$_loggers[$identifier] = new $className($configuration);
        }
        return self::$_loggers[$identifier];
    }
    
    /**
     * Adds another logger. This can be used to add loggers from other vendors.
     * If there's another logger with the same name, this method has no effect.
     * 
     * @param \Psr\Log\LoggerInterface $logger
     *   The logger
     * @param string $identifier
     *   The identifying name of the logger to get this later on call of
     *   \Gustav\Utils\Log\LogManager::getLogger()
     */
    public static function addLogger(
        LoggerInterface $logger,
        string $identifier = ""
    ) {
        if(!isset(self::$_loggers[$identifier])) {
            self::$_loggers[$identifier] = $logger;
        }
    }
    
    /**
     * Returns the logger with the given name.
     * 
     * @param string $identifier
     *   The identifying name of the logger to get this later on call of
     *   \Gustav\Utils\Log\LogManager::getLogger()
     * @return \Psr\Log\LoggerInterface
     *   The logger
     * @throws \Gustav\Utils\Log\LogException
     *   Unknown logger
     */
    public static function getLoggerByIdentifier(
        string $identifier = ""
    ): LoggerInterface {
        if(!isset(self::$_loggers[$identifier])) {
            throw LogException::unknownLogger($identifier);
        }
        return self::$_loggers[$identifier];
    }
}