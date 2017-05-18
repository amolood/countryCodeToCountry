<?php
/**
 * countryCodeToCountry
 *
 * Description:  Date: 17/05/2017 01:37 AM
 *
 * PHP version 5.5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Amer Anwar <adaroobi@hotmail.com>
 * @copyright  2006-2017 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    $Id$
 * @link       http://
 * @see        http://
 * @since      File available since Release 0.0.0
 */
namespace Amolood\countrycodeToCountryname;

use Amolood\countrycodeToCountryname\Exceptions\InvalidCountryCode;


/**
 * CountryCode
 *
 * Long description for CountryCode (if any)...
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Amer Anwar <adaroobi@hotmail.com>
 * @copyright  2006-2017
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: @package_version@
 * @link       http://
 * @see        http://
 * @since      Class available since Release 0.0.0
 */
class CountryCode
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var Config
     */
    protected $paths;

    /**
     * @var array
     */
    protected $countries = [];

    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
        $this->paths = Config::instance('paths');
        $countryListDirectory = $this->paths->optionValue('vendor_dir') . DS . 'umpirsky' . DS . 'country-list' . DS . 'data' . DS;
        $this->countries = require  $countryListDirectory . $this->locale->name() . DS . 'country.php';
    }

    public function name($code)
    {
        if (!$this->exists($code)) {
            throw new InvalidCountryCode("Code {$code} is invalid");
        }

        return $this->countries[$code];
    }

    public function exists($code)
    {
        return array_key_exists($code, $this->countries);
    }

    public function all($codesOnly = false)
    {
        return $codesOnly ? array_keys($this->countries) : $this->countries;
    }
}