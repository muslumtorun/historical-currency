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
use SimpleXMLElement;

abstract class AbstractHCurrency
{
    private $url = "https://tcmb.gov.tr/kurlar/";

    /**
     * Url Rule: https://tcmb.gov.tr/kurlar/[folder]/[file].xml -
     * [folder]: 4-digit year and a 2-digit month (Exp: yyyymm) -
     * [file]: Turkish date format (Exp: ddmmyyyy).
     * @param string $date (yyyy-mm-dd)
     * @return string URL rule is created.
     */

    protected function resolveUrl(string $date): string
    {
        $date = new DateTime($date);

        $folder = $date->format("Ym"); // yyyymm
        $file = $date->format("dmY"); //ddmmyyyy

        return "{$this->url}{$folder}/{$file}.xml";
    }

    /**
     * Returns url content.
     * @param string $url Must be resolved by resolveUrl method.
     * @return string The url content
     */

    protected function fetch(string $url): string
    {
        return file_get_contents($url);
    }

    /**
     * @param string $url_content is an xml string
     * @return SimpleXMMLElement 
     */

    protected function parseXML(string $url_content)
    {
        return new SimpleXMLElement($url_content);
    }

    /**
     * TCMB XML data contains a xsl interface like 'xml-stylesheet type="text/xsl" href="isokur.xsl"' to render.
     * The interface can cause problems if we don't remove this xsl line.
     * @return string a new XML string without the xls line.
     */
    protected function fixXMLString(string $xmlstring): string
    {
        return str_replace('<?xml-stylesheet type="text/xsl" href="isokur.xsl"?>', "", $xmlstring);
    }
}
