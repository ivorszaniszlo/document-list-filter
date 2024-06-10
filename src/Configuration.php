<?php

namespace DocumentFilter;

/**
 * Class Configuration
 * 
 * Handles the configuration settings for the application.
 */
class Configuration
{
    /**
     * @var array The configuration settings.
     */
    private $settings;

    /**
     * Configuration constructor.
     * 
     * Loads the configuration settings from the specified file.
     * Ensures the configuration file exists and is readable.
     *
     * @param string $configFile The path to the configuration file.
     */
    public function __construct($configFile)
    {
        if (!file_exists($configFile) || !is_readable($configFile)) {
            throw new \Exception("Configuration file cannot be loaded: {$configFile}");
        }
        $this->settings = require $configFile;
    }

    /**
     * Get a configuration setting by key.
     *
     * @param string $key The key of the configuration setting.
     * @return mixed The value of the configuration setting or null if the key is not set.
     */
    public function get($key)
    {
        return isset($this->settings[$key]) ? $this->settings[$key] : null;
    }
}
