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
 * This class is used for representation of some constants that represent data
 * types especially in queries and entities in ORM.
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   http://gustav.fieselschweif.de
 * @since  1.0
 */
class Types
{
    /**
     * This constant represents the data type of integer numbers with 32 bits.
     *
     * @var integer
     */
    const TYPE_INT = 1;

    /**
     * This constant represents the data type of integer numbers with 64 bits.
     *
     * @var integer
     */
    const TYPE_LONG = 2;

    /**
     * This constant represents the data type of integer numbers with 16 bits.
     *
     * @var integer
     */
    const TYPE_SHORT = 3;

    /**
     * This constant represents the data type of boolean values (i.e. values are
     * true or false).
     *
     * @var integer
     */
    const TYPE_BOOLEAN = 4;

    /**
     * This constant represents the data type of floating-point numbers with
     * 32 bits.
     *
     * @var integer
     */
    const TYPE_FLOAT = 5;

    /**
     * This constant represents the data type of strings without length
     * restriction.
     *
     * @var integer
     */
    const TYPE_STRING = 6;

    /**
     * This constant represents the data type of strings with exact length. The
     * length of the string has to be set separately in "length".
     *
     * @var integer
     */
    const TYPE_CHAR = 7;

    /**
     * This constant represents the data type of strings with maximum length.
     * The maximum length of the string has to be set separately in "length".
     *
     * @var integer
     */
    const TYPE_VARCHAR = 8;

    /**
     * This constant represents the data type of associative data arrays.
     * Normally these arrays will be saved serialized as string.
     *
     * @var integer
     */
    const TYPE_ARRAY = 9;

    /**
     * This constant represents the data type of data objects. Normally these
     * arrays will be saved serialized as string.
     *
     * @var integer
     */
    const TYPE_OBJECT = 10;

    /**
     * This constant represents PHPs DateTime type. These will be saved as
     * SQL DATETIME or TIMESTAMP.
     *
     * @var integer
     */
    const TYPE_DATE = 11;

    /**
     * Checks whether the given type expression (that means, one of the
     * constants above or a class name) matches to an integer like type
     *
     * @param integer|string $type
     *   The type to check
     * @return boolean
     *   true, if the type represents an integer, otherwise false
     */
    public static function isInteger($type): bool
    {
        return (\is_int($type) && $type <= self::TYPE_SHORT);
    }

    /**
     * Checks whether the given type expression (that means, one of the
     * constants above or a class name) matches to an string like type.
     *
     * @param integer|string $type
     *   The type to check
     * @return boolean
     *   true, if the type represents a string, otherwise false
     */
    public static function isString($type): bool
    {
        return (
            \is_int($type) &&
            $type >= self::TYPE_STRING &&
            $type <= self::TYPE_VARCHAR
        );
    }

    /**
     * Checks whether the given type expression (that means, one of the
     * constants above or a class name) matches to an numeric type.
     *
     * @param integer|string $type
     *   The type to check
     * @return boolean
     *   true, if the type represents a numeric type, otherwise false
     */
    public static function isNumeric($type): bool
    {
        return (\is_int($type) && $type <= self::TYPE_FLOAT);
    }

    /**
     * Checks whether the given type expression (that means, one of the
     * constants above or a class name) matches to an scalar type.
     *
     * @param integer|string $type
     *   The type to check
     * @return boolean
     *   true, if the type represents a scalar type, otherwise false
     */
    public static function isScalar($type): bool
    {
        return (\is_int($type) && $type <= self::TYPE_VARCHAR);
    }

    /**
     * Outputs the (internal) representation of data type in user readable kind.
     *
     * @param integer|string $type
     *   The (internal) data type
     * @return string
     *   The user readable type
     */
    public static function fetchType($type): string
    {
        if(\is_int($type)) {
            switch($type) {
                case Types::TYPE_INT:
                    return "integer";
                case Types::TYPE_LONG:
                    return "long";
                case Types::TYPE_SHORT:
                    return "short";
                case Types::TYPE_BOOLEAN:
                    return "boolean";
                case Types::TYPE_FLOAT:
                    return "float";
                case Types::TYPE_STRING:
                    return "string";
                case Types::TYPE_CHAR:
                    return "char";
                case Types::TYPE_VARCHAR:
                    return "varchar";
                case Types::TYPE_ARRAY:
                    return "array";
                case Types::TYPE_OBJECT:
                    return "object";
                case Types::TYPE_DATE:
                    return "date";
            }
        }
        return (string) $type;
    }
}