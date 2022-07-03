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

interface InterfaceHCurrency
{
    public function getDate(): string;
    public function getURL(): string;
    public function getXML(): string;
    public function getJSON(): string;
    public function getCurrencies(): array;
    public function getCurrency(string $currency_code): array;
    public function listCurrencyCodes(): array;
    public function isCurrencyCodeValid(string $currency_code): bool;
}
