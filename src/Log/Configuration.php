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

use Gustav\Utils\Miscellaneous;
use Psr\Log\LoggerInterface;

/**
 * The configuration of the error logger.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class Configuration
{
    /**
     * The identifier of the logger.
     * 
     * @var string
     */
    private $_identifier;
    
    /**
     * The class name of the logger implementation to use here. This class has
     * to implement interface \Psr\Log\LoggerInterface. Defaults to output on
     * standard output (\Gustav\Utils\Log\PrintLogger).
     * 
     * @var string
     */
    private $_implementation;
    
    /**
     * The fully qualified name of the log file, if we use FileLogger.
     * 
     * @var string
     */
    private $_fileName = "";
    
    /**
     * Constructor of this class.
     *
     * @param string $identifier
     *   The identifier of the logger
     * @param string $className
     *   The class name of the logger implementation to use here. Consider that
     *   this class has to implement interface \Psr\Log\LoggerInterface
     * @throws \Gustav\Utils\Log\LogException
     *   Invalid implementation
     */
    public function __construct(
        string $identifier = "",
        string $className = PrintLogger::class
    ) {
        if(!Miscellaneous::implementsInterface($className, LoggerInterface::class)) {
            throw LogException::invalidImplementation($className);
        }
        $this->_identifier = $identifier;
        $this->_implementation = $className;
    }
    
    /**
     * Returns the identifier of the logger to use here.
     * 
     * @return string
     *   The logger's identifier
     */
    public function getIdentifier(): string
    {
        return $this->_identifier;
    }
    
    /**
     * Returns the class name of the logger implementation to use here.
     * 
     * @return string
     *   The class name of the implementation
     */
    public function getImplementation(): string
    {
        return $this->_implementation;
    }
    
    /**
     * Sets the fully qualified name (i.e. incl. the directory) of the log file.
     * 
     * @param string $fileName
     *   The file name of the log file
     * @return \Gustav\Utils\Log\Configuration
     *   This object
     */
    public function setFileName(string $fileName): self
    {
        $this->_fileName = $fileName;
        return $this;
    }
    
    /**
     * Returns the fully qualified name of the log file.
     * 
     * @return string
     *   The file name of the log file
     */
    public function getFileName(): string
    {
        return $this->_fileName;
    }
    
    //TODO: mail configuration!!!
}