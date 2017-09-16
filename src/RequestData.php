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
 * This class manages all the request and input data.
 * 
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class RequestData
{
    /**
     * These constant represent different HTTP request methods.
     */
    public const HEAD = 1;
    public const POST = 2;
    public const GET = 3;
    public const PUT = 4;
    public const DELETE = 5;
    
    /**
     * The current used HTTP request method.
     * 
     * @var integer
     */
    private static $_method;
    
    /**
     * The array containing all the input data.
     * 
     * @var array
     */
    private static $_data = [];
    
    /**
     * This property indicates whether the current request uses HTTPS (true) or
     * simple HTTP (false).
     * 
     * @var boolean
     */
    private static $_https;
    
    /**
     * The called (sub-)domain. This is reasonable especially in systems with
     * more than one domain resp. sub-domain.
     * 
     * @var string
     */
    private static $_domain;
    
    /**
     * The file that was called. This includes the absolute path to the file,
     * too.
     * 
     * @var string
     */
    private static $_file;
    
    /**
     * The additional path information from request. This is the URL part
     * between file name and query string.
     * 
     * @var string
     */
    private static $_pathInfo;
    
    /**
     * The constructor of this class. This method should not be callable and so
     * it's private.
     */
    private function __construct()
    {
        //nothing to do...
    }
    
    /**
     * Initializes this class. This means, the request and input data will be
     * loaded and parsed.
     */
    public static function initialize()
    {
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
        
        if(
            isset($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] !== null &&
            $_SERVER['HTTPS'] !== "off"
        ) {
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
     * @param array $data
     *   The data to add
     */
    private static function _parseData(array $data)
    {
        foreach($data as $key => $value) {
            self::$_data[\mb_strtolower($key)] = $value;
        }
    }
    
    /**
     * Returns the HTTP request method. Consider that the value of one of the
     * constants above will be used as request method.
     *
     * @return integer
     *   The HTTP request method.
     */
    public static function getRequestMethod(): int
    {
        return self::$_method;
    }
    
    /**
     * Returns the value with the given key from input data.
     *
     * @param string $key
     *   The input key
     * @return mixed
     *   The input value
     */
    public static function getValue(string $key)
    {
        $key = \mb_strtolower($key);
        if(isset(self::$_data[$key])) {
            return self::$_data[$key];
        }
        return null;
    }
    
    /**
     * Checks whether a value t the given input key was set in the form.
     *
     * @param string $key
     *   The input key to check
     * @return boolean
     *   true, if the value exists, otherwise, false
     */
    public static function issetValue(string $key): bool
    {
        $key = \mb_strtolower($key);
        return isset(self::$_data[$key]);
    }
    
    /**
     * Checks whether the current request uses HTTPS (true) or simple HTTP
     * (false).
     *
     * @return boolean
     *   true, if HTTPS was used, otherwise false
     */
    public static function isHttps(): bool
    {
        return self::$_https;
    }
    
    /**
     * Returns the called (sub-)domain.
     *
     * @return string
     *   The domain or sub-domain
     */
    public static function getDomain(): string
    {
        return self::$_domain;
    }
    
    /**
     * Returns the absolute path to the called file incl. the file name.
     *
     * @return string
     *   The called path and file
     */
    public static function getFile(): string
    {
        return self::$_file;
    }
    
    /**
     * Returns the path information from the current request. This is the URL
     * part between file name and query string.
     *
     * @return string
     *   The path information
     */
    public static function getPathInfo(): string
    {
        return self::$_pathInfo;
    }
}