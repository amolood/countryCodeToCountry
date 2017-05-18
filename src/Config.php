<?php

namespace Amolood\countrycodeToCountryname;

use Amolood\countrycodeToCountryname\Exceptions\InvalidConfigFile;

class Config
{
    /**
     * Default config directory
     */
    CONST CONFIG_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

    /**
     * Dependency container
     * @var array
     */
    protected static $loadedContainer = [];

    /**
     * Current loaded file name
     * @var string
     */
    protected $fileName;

    /**
     * Options loaded form the current file
     * @var array
     */
    protected $options = [];

    protected function __construct($fileName, $extension = 'php')
    {
        $this->fileName = "{$fileName}.{$extension}";

        if (!$this->isValidFile()) {
            throw new InvalidConfigFile(
                "Config file was not found or could not read in " . $this::CONFIG_DIR . "{$this->fileName}"
            );
        }

        $this->options = require $this::CONFIG_DIR . $this->fileName;
    }

    /**
     * Current loaded file name
     * @return string
     */
    public function fileName()
    {
        return $this->fileName;
    }

    /**
     * List of all loaded options
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Get all available options
     * @return array
     */
    public function optionNames()
    {
        return array_keys($this->options());
    }

    /**
     * Check whether option exists in current file
     * @param $option
     * @return bool
     */
    public function optionExists($option)
    {
        return in_array($option, $this->optionNames());
    }

    /**
     * Get the value of an option
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
     * Check if this is a valid file
     * @return bool
     */
    protected function isValidFile()
    {
        return file_exists($this::CONFIG_DIR . $this->fileName())
            && is_readable($this::CONFIG_DIR . $this->fileName());
    }

    /**
     * Make instantiation for current Config class which loads a config only once
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
     * Prepend Container with a new config instance
     * @param Config $config
     * @return Config
     */
    protected static function prependContainer(self $config)
    {
        return self::$loadedContainer[$config->fileName()] = $config;
    }

    /**
     * Get a config instance for an arbitrary config file if exists
     * @param $configName
     * @return Config|mixed
     */
    public static function instance($configName)
    {
        return self::factory($configName);
    }

}