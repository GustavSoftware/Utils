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
     * The class name of the logger implementation to use here. This class has
     * to implement interface \Psr\Log\LoggerInterface.
     * 
     * @var string
     */
    private $_implementation = FileLogger::class;
    
    /**
     * The fully qualified name of the log file, if we use FileLogger.
     * 
     * @var string
     */
    private $_fileName = "";
    
    /**
     * Sets the class name of the implementation of \Psr\Log\LoggerInterface to
     * use here.
     *
     * @param string $className
     *   The class name of the implementation
     * @return \Gustav\Utils\Log\Configuration
     *   This object
     * @throws \Gustav\Utils\Log\LogException
     *   Invalid implementation
     */
    public function setImplementation(string $className): self
    {
        if(!Miscellaneous::implementsInterface($className, LoggerInterface::class)) {
            throw LogException::invalidImplementation($className);
        }
        $this->_implementation = $className;
        return $this;
    }
    
    /**
     * Returns the class name of the logger implementation to use here.
     * 
     * @return string
     *   The class name of the implementation
     */
    public function getImplementation()
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
    public function getFileName()
    {
        return $this->_fileName;
    }
    
    //TODO: mail configuration!!!
}