<?php
namespace Amolood\countrycodeToCountryname;

use Amolood\countrycodeToCountryname\Exceptions\InvalidCountryCode;


class CountryCode
{
    /**
     * Locale instance
     * @var Locale
     */
    protected $locale;

    /**
     * Loaded countries
     * @var array
     */
    protected $countries = [];

    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
        $countryListDirectory = Config::instance('paths')
                ->optionValue('vendor_dir') . DS . 'umpirsky' . DS . 'country-list' . DS . 'data' . DS;

        $this->countries = require  $countryListDirectory . $this->locale->name() . DS . 'country.php';
    }

    /**
     * Get Country name using code
     * @param $code
     * @return string
     * @throws InvalidCountryCode
     */
    public function name($code)
    {
        if (!$this->exists($code)) {
            throw new InvalidCountryCode("Code {$code} is invalid");
        }

        return $this->countries[$code];
    }

    /**
     * Check if a code exists
     * @param $code
     * @return bool
     */
    public function exists($code)
    {
        return array_key_exists($code, $this->countries);
    }

    /**
     * Get a list of all available countries with its codes (if selected) for current locale
     * @param bool $codesOnly
     * @return array
     */
    public function all($codesOnly = false)
    {
        return $codesOnly ? array_keys($this->countries) : $this->countries;
    }
}