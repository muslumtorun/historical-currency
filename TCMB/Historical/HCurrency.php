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

use TCMB\Historical\AbstractHCurrency;
use TCMB\Historical\InterfaceHCurrency;
use TCMB\Historical\ExceptionHCurrency;
use TCMB\Historical\Utility;
use Exception;

/**
 * A library that can be used to get historical currency rates.
 */

final class HCurrency extends AbstractHCurrency implements InterfaceHCurrency
{
    /** Activated after this date. (yyyy-mm-dd) */
    const MINDATE = "1996-05-01";

    protected $url;
    protected $date;
    protected $xmldata;
    protected $arraydata;

    /** @param string $date format is yyyy-mm-dd */
    public function __construct(string $date)
    {
        $this->date = $date;
        $this->init();
    }

    private function init(): void
    {
        if (!Utility::isDateValid($this->date)) {
            throw new ExceptionHCurrency("Invalid date! Date must be a string and yyyy-mm-dd format.");
        } else if (!(strtotime($this->date) > strtotime(self::MINDATE))) {
            throw new ExceptionHCurrency("The date must be greater than " . self::MINDATE);
        } else if (!(strtotime($this->date) < time())) {
            throw new ExceptionHCurrency("The date must be smaller than today.");
        } else if (Utility::isWeekend($this->date)) {
            $this->date = Utility::bringTheFriday($this->date);
        }

        $this->url = $this->resolveUrl($this->date);

        try {
            $fetch = (string) $this->fetch($this->url); // get url content
            $fixedXML = $this->fixXMLString($fetch);

            $this->xmldata = $fixedXML; // keep xml string
            $this->prepareEnvironment(); // xml data processing
        } catch (Exception $err) {
            throw new ExceptionHCurrency($err->getMessage());
        }
    }

    /**
     * This method converts the XML elements and values to an array.
     */

    private function prepareEnvironment(): void
    {
        if (!$this->xmldata) {
            throw new ExceptionHCurrency("XML string could not be retrieved from " . $this->url);
        }

        try {
            $parse = $this->parseXML($this->xmldata); //convert to SimleXMLElement
            $container = [];

            foreach ($parse->Currency as $currency) {
                $row = [];

                //get attributes
                foreach ($currency->attributes() as $attr => $attrvalue) {
                    $row[$attr] = (string) $attrvalue;
                }

                //get elements
                foreach ($currency as $element => $elementvalue) {
                    $row[$element] = (string) $elementvalue;
                }

                array_push($container, $row);
            }

            $this->arraydata = $container;
        } catch (Exception $err) {
            throw new ExceptionHCurrency($err->getMessage());
        }
    }

    /**
     * List of the supported currency codes.
     * @return array [CurrencyName => United States Dollar, Isim => Amekian Doları, CurrencyCode => USD]
     */

    public function listCurrencyCodes(): array
    {
        if (!$this->arraydata) {
            throw new ExceptionHCurrency("XML string could not be retrieved from " . $this->url);
        }

        $container = [];
        foreach ($this->arraydata as $currency) {
            $rows = [];
            $rows["CurrencyName"] = (string) $currency["CurrencyName"];
            $rows["Isim"] = (string) $currency["Isim"];
            $rows["CurrencyCode"] = (string) $currency["CurrencyCode"];

            array_push($container, $rows);
        }

        return $container;
    }

    /**
     * Checks if the currency code is valid.
     * @param string $currency_code Ex: usd, eur...
     * @return boolean
     */

    public function isCurrencyCodeValid(string $currency_code): bool
    {
        foreach ($this->listCurrencyCodes() as $item) {
            if (in_array(strtoupper($currency_code), $item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns selected currency rates.
     * @param string $currency_code Must be a valid code from the supported list.
     * @return array
     */

    public function getCurrency(string $currency_code = "usd"): array
    {
        if (!$this->arraydata) {
            throw new ExceptionHCurrency("XML string could not be retrieved from " . $this->url);
        } else if (!$this->isCurrencyCodeValid($currency_code)) {
            throw new ExceptionHCurrency("{$currency_code} currency code is invalid! You can list of the valid codes using listCurrencyCodes() method.");
        }

        foreach ($this->arraydata as $currency) {
            if ($currency["CurrencyCode"] == strtoupper($currency_code)) {
                return $currency;
            }
        }

        return [];
    }

    /**
     * Returns an array of the data from the resolved TCMB url.
     */

    public function getCurrencies(): array
    {
        if (!$this->arraydata) {
            throw new ExceptionHCurrency("XML string could not be retrieved from " . $this->url);
        }

        return $this->arraydata;
    }

    /**
     * Returns the resolved TCMB url.
     */

    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * Returns the raw xml data from the resolved TCMB url.
     */

    public function getXML(): string
    {
        return $this->xmldata;
    }

    /**
     * Returns a JSON string of the data.
     */

    public function getJSON(): string
    {
        return json_encode($this->arraydata);
    }

    /**
     * Returns the selected date.
     */

    public function getDate(): string
    {
        return $this->date;
    }
}
