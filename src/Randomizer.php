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
 * This class can and should be used for generation of random numbers or
 * strings.
 * 
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class Randomizer
{
    /**
     * This property indicates whether the randomizer was seeded yet. Seeding
     * the randomizer will result in more randomness. On every method call of
     * this class, the randomizer can be seeded again. Consider that multiple
     * seeding is increasing security but decreasing performance.
     *
     * @var boolean
     */
    private static $_seeded = false;
    
    /**
     * Creates a random alphanumeric string with the given length.
     *
     * @param integer $length
     *   The length of the string (default is 20)
     * @param boolean $forceSeed
     *   true, if randomizer should be seeded again
     * @return string
     *   A random string with the given length
     */
    public static function getString(
        int $length = 20,
        bool $forceSeed = false
    ): string {
        $set = [
            "a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H",
            "i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P",
            "q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X",
            "y","Y","z","Z","0","1","2","3","4","5","6","7","8","9"
        ];
        $output = "";
        
        for($i = 1; $i <= $length; $i++) {
            $ch = self::getInt(0, 61, $forceSeed);
            $output .= $set[$ch];
        }
        
        return $output;
    }
    
    /**
     * Creates a random integer number within the given range. If the given
     * minimum is greater than the given maximum, then the complete 64 bit
     * range of integers will be used.
     *
     * @param integer $min
     *   The ranges lower bound
     * @param integer $max
     *   The ranges upper bound
     * @param  boolean $forceSeed
     *   true, if randomizer should be seeded again
     * @return integer
     *   A random integer
     */
    public static function getInt(
        int $min = 0,
        int $max = -1,
        bool $forceSeed = false
    ): int {
        if(self::$_seeded === false || $forceSeed === true) {
            self::_seedRandomizer();
        }
        
        if($max > $min) {
            return mt_rand($min, $max);
        } else {
            return mt_rand();
        }
    }
    
    /**
     * Creates a random floating point number within the given range. If the
     * given minimum is greater than the given maximum, then the complete 64
     * bit range of floats will be used.
     *
     * @param integer $min
     *   The ranges lower bound
     * @param integer $max
     *   The ranges upper bound
     * @param boolean $forceSeed
     *   true, if randomizer should be seeded again
     * @return float
     *   A random float
     */
    public static function getFloat(
        int $min = 0,
        int $max = 1,
        bool $forceSeed = false
    ): float {
        if($max > $min) {
            return $min + (float) self::getInt(0, -1, $forceSeed) /
                mt_getrandmax() * ($max - $min);
        } else {
            return (float) self::getInt(0, -1, $forceSeed) / mt_getrandmax();
        }
    }
    
    /**
     * Creates a new random seed for more randomness.
     **/
    private static function _seedRandomizer()
    {
        self::$_seeded = true;
        
        $seed = \hexdec(\bin2hex(\openssl_random_pseudo_bytes(8)));
        \mt_srand($seed);
    }
}