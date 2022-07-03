<?php

/**
 * HCurrency - A library that can be used to get historical currency rates.
 * 
 * @see https://github.com/muslumtorun/historical-currency/ The Historical Currency GitHub project
 * 
 * @author Muslum Torun <https://benahce.net/muslumtorun>
 * @copyright 2022 Muslum Torun
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace TCMB\Historical;

use DateTime;

/**
 * Base class for the some methods.
 */

class Utility
{
    /**
     * @param string $date needs a date format like yyyy-mm-dd
     * @return boolean
     */
    public static function isFormatValid(string $date): bool
    {
        return preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $date);
    }

    /**
     * @param string $date needs a yyyy-mm-dd format
     * @return boolean
     */
    public static function isDateValid(string $date): bool
    {
        if (self::isFormatValid($date)) {
            $explode = explode("-", $date);
            return checkdate((int) $explode[1], (int) $explode[2], (int) $explode[0]);
        }

        return false;
    }

    /**
     * @param string $date needs a valid yyyy-mm-dd format
     * @return boolean
     */
    public static function isWeekend(string $date): bool
    {
        if (self::isDateValid($date)) {
            return date("N", strtotime($date)) >= 6;
        }

        return false;
    }

    /**
     * Returns friday of the week if the date is a weekend.
     * @param string $date yyyy-mm-dd.
     * @return string yyyy-mm-dd.
     */

     public static function bringTheFriday(string $date): string {
        if (self::isWeekend($date)) {
            $diff = 5 - (date("N", strtotime($date)));
            
            $friday = new DateTime($date);
            return $friday->modify("{$diff} days")->format("Y-m-d");
        }

        return $date;
     }
}
