<?php

/**
 * HCurrency - A library that can be used to get historical currency rates.
 * 
 * @see https://github.com/muslumtorun/historical-currency/ The Historical Currency GitHub project
 * 
 * @author Muslum Torun <https://benahce.net/muslumtorun>
 * @copyright 2024 Muslum Torun
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace TCMB\Historical\Types;

class Response {
    const CROSSORDER = "CrossOrder";
    const KOD = "Kod";
    const CURRENCYCODE = "CurrencyCode";
    const UNIT = "Unit";
    const ISIM = "Isim";
    const CURRENCYNAME = "CurrencyName";
    const FOREXBUYING = "ForexBuying";
    const FOREXSELLING = "ForexSelling";
    const BANKNOTEBUYING = "BanknoteBuying";
    const BANKNOTESELLING = "BanknoteSelling";
    const CROSSRATEUSD = "CrossRateUSD";
    const CROSSRATEOTHER = "CrossRateOther";
}