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
 * This class implements some miscellaneous functions that are needed in
 * various places in CMS and other Gustav projects.
 * 
 * @author  Chris Köcher <ckone@fieselschweif.de>
 * @link    http://gustav.fieselschweif.de
 * @package Gustav.Utils
 * @since   1.0
 */
class Miscellaneous {
    /**
     * Checks whether the class or object in first argument implements the
     * interface with name in second argument.
     *
     * @param  mixed   $class     The class name or object
     * @param  string  $interface The interface name
     * @return boolean            true, if the class/object implements the
     *                            interface, otherwise false
     * @static
     */
    public static function implementsInterface($class, $interface) {
        $reflection = new \ReflectionClass($class);
        return $reflection->implementsInterface($interface);
    }
    
    /**
     * Checks whether the class or object in first argument uses the trait with
     * name in second argument.
     * 
     * @param  mixed   $class The class name or object
     * @param  string  $trait The trait name
     * @return boolean        true, if the class/object uses the trait,
     *                        otherwise false
     * @static
     */
    public static function usesTrait($class, $trait) {
        $reflection = new \ReflectionClass($class);
        if(\mb_substr($trait, 0, 1) === "\\") { //remove the leading backslash
            $trait = \mb_substr($trait, 1);
        }
        return \in_array($trait, $reflection->getTraitNames());
    }
    
    /**
     * Checks if a given class name begins with a "\" and adds this if not.
     *
     * @param  string $className The class name to check
     * @return string            The class name with leading "\"
     * @static
     */
    public static function prepareClassName($className) {
        $className = (string) $className;
        if(\mb_strpos($className, "\\") !== 0) {
            return "\\" . $className;
        }
        return $className;
    }
    
    /**
     * Converts a integer value into an unicode symbol with this code number.
     *
     * @param  int    $code The code number
     * @return string       The unicode symbol
     * @static
     */
    public static function getUnicodeChar($code) {
        return mb_convert_encoding("&#" . intval($code) . ";", "UTF-8",
                "HTML-ENTITIES");
    }
    
    /**
     * Removes some unneeded or annoying whitespace characters from begin and
     * end of a string. This is a extension of PHPs \trim() to remove unicode
     * whitespace, too.
     * This method was copied from MyBBs trim_blank_chrs().
     *
     * @param  string $string The string to trim
     * @return string         The string without whitespace on begin and end
     * @see    http://crossreference.mybboard.de/nav.html?inc/functions.php.html
     * @static
     */
    public static function trimBlanks($string) {
        $hex_chars = array(
            0x09 => 1, // \x{0009}
            0x0A => 1, // \x{000A}
            0x0B => 1, // \x{000B}
            0x0D => 1, // \x{000D}
            0x20 => 1, // \x{0020}
            0xC2 => array(0x81 => 1, 0x8D => 1, 0x90 => 1, 0x9D => 1, 0xA0 => 1, 0xAD => 1), // \x{0081}, \x{008D}, \x{0090}, \x{009D}, \x{00A0}, \x{00AD}
            0xCC => array(0xB7 => 1, 0xB8 => 1), // \x{0337}, \x{0338}
            0xE1 => array(0x85 => array(0x9F => 1, 0xA0 => 1), 0x9A => array(0x80 => 1), 0xA0 => array(0x8E => 1)), // \x{115F}, \x{1160}, \x{1680}, \x{180E}
            0xE2 => array(0x80 => array(0x80 => 1, 0x81 => 1, 0x82 => 1, 0x83 => 1, 0x84 => 1, 0x85 => 1, 0x86 => 1, 0x87 => 1, 0x88 => 1, 0x89 => 1, 0x8A => 1, 0x8B => 1, 0x8C => 1, 0x8D => 1, 0x8E => 1, 0x8F => 1, // \x{2000} - \x{200F}
                                        0xA8 => 1, 0xA9 => 1, 0xAA => 1, 0xAB => 1, 0xAC => 1, 0xAD => 1, 0xAE => 1, 0xAF => 1), // \x{2028} - \x{202F}
                          0x81 => array(0x9F => 1)), // \x{205F}
            0xE3 => array(0x80 => array(0x80 => 1), // \x{3000}
                          0x85 => array(0xA4 => 1)), // \x{3164}
            0xEF => array(0xBB => array(0xBF => 1), // \x{FEFF}
                          0xBE => array(0xA0 => 1), // \x{FFA0}
                          0xBF => array(0xB9 => 1, 0xBA => 1, 0xBB => 1)), // \x{FFF9} - \x{FFFB}
        );
        $hex_chars_rev = array(
            0x09 => 1, // \x{0009}
            0x0A => 1, // \x{000A}
            0x0B => 1, // \x{000B}
            0x0D => 1, // \x{000D}
            0x20 => 1, // \x{0020}
            0x81 => array(0xC2 => 1, 0x80 => array(0xE2 => 1)), // \x{0081}, \x{2001}
            0x8D => array(0xC2 => 1, 0x80 => array(0xE2 => 1)), // \x{008D}, \x{200D}
            0x90 => array(0xC2 => 1), // \x{0090}
            0x9D => array(0xC2 => 1), // \x{009D}
            0xA0 => array(0xC2 => 1, 0x85 => array(0xE1 => 1), 0x81 => array(0xE2 => 1), 0xBE => array(0xEF => 1)), // \x{00A0}, \x{1160}, \x{2060}, \x{FFA0}
            0xAD => array(0xC2 => 1, 0x80 => array(0xE2 => 1)), // \x{00AD}, \x{202D}
            0xB8 => array(0xCC => 1), // \x{0338}
            0xB7 => array(0xCC => 1), // \x{0337}
            0x9F => array(0x85 => array(0xE1 => 1), 0x81 => array(0xE2 => 1)), // \x{115F}, \x{205F}
            0x80 => array(0x9A => array(0xE1 => 1), 0x80 => array(0xE2 => 1, 0xE3 => 1)), // \x{1680}, \x{2000}, \x{3000}
            0x8E => array(0xA0 => array(0xE1 => 1), 0x80 => array(0xE2 => 1)), // \x{180E}, \x{200E}
            0x82 => array(0x80 => array(0xE2 => 1)), // \x{2002}
            0x83 => array(0x80 => array(0xE2 => 1)), // \x{2003}
            0x84 => array(0x80 => array(0xE2 => 1)), // \x{2004}
            0x85 => array(0x80 => array(0xE2 => 1)), // \x{2005}
            0x86 => array(0x80 => array(0xE2 => 1)), // \x{2006}
            0x87 => array(0x80 => array(0xE2 => 1)), // \x{2007}
            0x88 => array(0x80 => array(0xE2 => 1)), // \x{2008}
            0x89 => array(0x80 => array(0xE2 => 1)), // \x{2009}
            0x8A => array(0x80 => array(0xE2 => 1)), // \x{200A}
            0x8B => array(0x80 => array(0xE2 => 1)), // \x{200B}
            0x8C => array(0x80 => array(0xE2 => 1)), // \x{200C}
            0x8F => array(0x80 => array(0xE2 => 1)), // \x{200F}
            0xA8 => array(0x80 => array(0xE2 => 1)), // \x{2028}
            0xA9 => array(0x80 => array(0xE2 => 1)), // \x{2029}
            0xAA => array(0x80 => array(0xE2 => 1)), // \x{202A}
            0xAB => array(0x80 => array(0xE2 => 1)), // \x{202B}
            0xAC => array(0x80 => array(0xE2 => 1)), // \x{202C}
            0xAE => array(0x80 => array(0xE2 => 1)), // \x{202E}
            0xAF => array(0x80 => array(0xE2 => 1)), // \x{202F}
            0xA4 => array(0x85 => array(0xE3 => 1)), // \x{3164}
            0xBF => array(0xBB => array(0xEF => 1)), // \x{FEFF}
            0xB9 => array(0xBF => array(0xEF => 1)), // \x{FFF9}
            0xBA => array(0xBF => array(0xEF => 1)), // \x{FFFA}
            0xBB => array(0xBF => array(0xEF => 1)), // \x{FFFB}
        );
        
        // Start from the beginning and work our way in
        do {
            // Check to see if we have matched a first character in our utf-16 array
            $offset = self::_match_sequence($string, $hex_chars);
            if(!$offset) {
                // If not, then we must have a "good" character and we don't need to do anymore processing
                break;
            }
            $string = \substr($string, $offset);
        } while(true);
        
        // Start from the end and work our way in
        $string = \strrev($string);
        do {
            // Check to see if we have matched a first character in our utf-16 array
            $offset = self::_match_sequence($string, $hex_chars_rev);
            if(!$offset) {
                // If not, then we must have a "good" character and we don't need to do anymore processing
                break;
            }
            $string = \substr($string, $offset);
        } while(true);
        
        $string = \strrev($string);
        $string = \trim($string);
        
        return $string;
    }
    
    /**
     * This method clones an array recursively. So all objects contained in this
     * array will be cloned correctly.
     * 
     * @param  array $array The array to clone
     * @return array        The cloned array
     */
    public static function cloneArray(array $array) {
        $newArray = array();
        foreach($array as $key => $value) {
            if(\is_object($value)) {
                $newArray[$key] = clone $value;
            } elseif(\is_array($value)) {
                $newArray[$key] = self::cloneArray($value);
            } else {
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }

    /**
     * Matches a sequence.
     * This method was copied from MyBBs match_sequence().
     *
     * @param  string  $string The string to match from
     * @param  array   $array  The array to match from
     * @param  integer $i      Number in the string
     * @param  integer $n      Number of matches
     * @return integer         The number matched
     * @see    http://crossreference.mybboard.de/nav.html?inc/functions.php.html
     * @static
     */
    private static function _match_sequence($string, $array, $i=0, $n=0) {
        if($string === "") {
            return 0;
        }
        $ord = \ord($string[$i]);
        if(\array_key_exists($ord, $array)) {
            $level = $array[$ord];
            ++$n;
            if(\is_array($level)) {
                ++$i;
                return self::_match_sequence($string, $level, $i, $n);
            }
            return $n;
        }
        return 0;
    }
}