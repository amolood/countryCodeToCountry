<?php
/**
 * countryCodeToCountry
 *
 * Description:  Date: 17/05/2017 11:46 PM
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

use Amolood\countrycodeToCountryname\Exceptions\InvalidConfigFile;

/**
 * Config
 *
 * Long description for Config (if any)...
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
class Config
{
    /**
     * Default config directory
     */
    CONST CONFIG_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'config';

    /**
     * Dependency container
     * @var array
     */
    protected static $loadedContainer = [];

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var array
     */
    protected $options = [];

    protected function __construct($fileName, $extension = 'php')
    {
        $this->fileName = "{$fileName}.{$extension}";

        if (!$this->isValidFile()) {
            throw new InvalidConfigFile("Config file was not found or could not read");
        }

        $this->options = require $this::CONFIG_DIR . $fileName;
    }

    /**
     * @return string
     */
    public function fileName()
    {
        return $this->fileName;
    }

    /**
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function optionNames()
    {
        return array_keys($this->options());
    }

    /**
     * @param $option
     * @return bool
     */
    public function optionExists($option)
    {
        return in_array($option, $this->optionNames());
    }

    /**
     * @param $option
     * @return mixed|null
     */
    public function optionValue($option)
    {
        return $this->optionExists($option) ?
            $this->options()[$option] :
            null;
    }

    /**
     * @return bool
     */
    protected function isValidFile()
    {
        return file_exists($this->fileName()) && is_readable($this->fileName());
    }

    /**
     * @param $configName
     * @return Config|mixed
     */
    protected static function factory($configName)
    {
        return array_key_exists($configName, self::$loadedContainer) ?
            self::$loadedContainer[$configName] :
            self::prependContainer(new self($configName));
    }

    /**
     * @param Config $config
     * @return Config
     */
    protected static function prependContainer(self $config)
    {
        return self::$loadedContainer[$config->fileName()] = $config;
    }

    /**
     * @param $configName
     * @return Config|mixed
     */
    public static function instance($configName)
    {
        return self::factory($configName);
    }

}