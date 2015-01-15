<?php

/*
 * Gustav ORM - A simple PHP framework for object-relational mappings.
 * Copyright (C) 2014  Chris Köcher
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
 * This class manages all the request and input data.
 * 
 * @author  Chris Köcher <ckone@fieselschweif.de>
 * @link    http://gustav.fieselschweif.de
 * @package Gustav.Utils
 * @since   1.0
 */
class RequestData {
    /**
     * These constant represent different HTTP request methods.
     */
    const HEAD = 1;
    const POST = 2;
    const GET = 3;
    const PUT = 4;
    const DELETE = 5;
    
    /**
     * The current used HTTP request method.
     * 
     * @var       integer
     * @staticvar
     */
    private static $_method;
    
    /**
     * The array containing all the input data.
     * 
     * @var       array
     * @staticvar
     */
    private static $_data = array();
    
    /**
     * This property indicates whether the current request uses HTTPS (true) or
     * simple HTTP (false).
     * 
     * @var       boolean
     * @staticvar
     */
    private static $_https;
    
    /**
     * The called (sub-)domain. This is reasonsable especially in systems with
     * more than one domain resp. subdomain.
     * 
     * @var       string
     * @staticvar
     */
    private static $_domain;
    
    /**
     * The file that was called. This includes the absolute path to the file,
     * too.
     * 
     * @var       string
     * @staticvar
     */
    private static $_file;
    
    /**
     * The additional path information from request. This is the URL part
     * between file name and query string.
     * 
     * @var       string
     * @staticvar
     */
    private static $_pathInfo;
    
    /**
     * The constructor of this class. This method should not be callable and so
     * it's private.
     */
    private function __construct() {
        //nothing to do...
    }
    
    /**
     * Initializes this class. This means, the request and input data will be
     * loaded and parsed.
     * 
     * @static
     */
    public static function initialize() {
        switch($_SERVER['REQUEST_METHOD']) {
            case "POST":
                self::$_method = self::POST;
                break;
            case "GET":
                self::$_method = self::GET;
                break;
            case "PUT":
                self::$_method = self::PUT;
                break;
            case "DELETE":
                self::$_method = self::DELETE;
                break;
            default:
                self::$_method = self::HEAD;
        }
        self::$_data = array();
        self::_parseData($_GET);
        self::_parseData($_POST);
        
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== null
                && $_SERVER['HTTPS'] !== "off") {
            self::$_https = true;
        } else {
            self::$_https = false;
        }
        
        self::$_domain = (string) $_SERVER['HTTP_HOST'];
        self::$_file = (string) $_SERVER['SCRIPT_FILENAME'];
        if(isset($_SERVER['PATH_INFO'])) {
            self::$_pathInfo = (string) $_SERVER['PATH_INFO'];
        } else {
            self::$_pathInfo = "";
        }
    }
    
    /**
     * Adds the given array data to the input data.
     * 
     * @param  array $data The data to add
     * @static
     */
    private static function _parseData(array $data) {
        foreach($data as $key => $value) {
            self::$_data[\mb_strtolower($key)] = $value;
        }
    }
    
    /**
     * Returns the HTTP request method. Consider that the value of one of the
     * constants above will be used as request method.
     * 
     * @return integer The HTTP request method.
     * @static
     */
    public static function getRequestMethod() {
        return self::$_method;
    }
    
    /**
     * Returns the value with the given key from input data.
     * 
     * @param  string $key The input key
     * @return mixed       The input value
     * @static
     */
    public static function getValue($key) {
        $key = \mb_strtolower((string) $key);
        if(isset(self::$_data[$key])) {
            return self::$_data[$key];
        }
    }
    
    /**
     * Checks whether a value t the given input key was set in the form.
     * 
     * @param  string  $key The input key to check
     * @return boolean      true, if the value exists, otherwise, false
     */
    public static function issetValue($key) {
        $key = \mb_strtolower((string) $key);
        return isset(self::$_data[$key]);
    }
    
    /**
     * Checks whether the current request uses HTTPS (true) or simple HTTP
     * (false).
     * 
     * @return boolean true, if HTTPS was used, otherwise false
     * @static
     */
    public static function isHttps() {
        return self::$_https;
    }
    
    /**
     * Returns the called (sub-)domain.
     * 
     * @return string The domain or subdomain
     * @static
     */
    public static function getDomain() {
        return self::$_domain;
    }
    
    /**
     * Returns the absolute path to the called file incl. the file name.
     * 
     * @return string The called path and file
     * @static
     */
    public static function getFile() {
        return self::$_file;
    }
    
    /**
     * Returns the path information from the current request. This is the URL
     * part between file name and query string.
     * 
     * @return string The path information
     * @static
     */
    public static function getPathInfo() {
        return self::$_pathInfo;
    }
}