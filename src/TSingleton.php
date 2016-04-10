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

namespace Gustav\Utils;

/**
 * This trait implements the Singleton design pattern. This means, classes that
 * use this trait can only be instantiated once.
 * 
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
trait TSingleton
{
    /**
     * The only instance of this class.
     *
     * @var self|null
     */
    private static $_instance = null;
    
    /**
     * This method is protected for avoiding of multiple instantiation of this
     * class. For instantiation use \Gustav\Utils\Singleton::getInstance()
     * instead. This method can be overwritten by the developer.
     */
    protected function __construct()
    {
        //nothing to do
    }
    
    /**
     * This method is private for avoiding of copying of instances of this
     * class. This method should not be overwritten by the developer!
     */
    private function __clone()
    {
        //nothing to do
    }
    
    /**
     * Returns the only instance of this class.
     *
     * @return self
     *   The only instance of this class
     */
    public static function getInstance(): self
    {
        if(self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}