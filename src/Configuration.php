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
     *
     * @param string $configFile The path to the configuration file.
     */
    public function __construct($configFile)
    {
        $this->settings = require $configFile;
    }

    /**
     * Get a configuration setting by key.
     *
     * @param string $key The key of the configuration setting.
     * @return mixed|null The value of the configuration setting or null if not found.
     */
    public function get($key)
    {
        return $key && isset($this->settings[$key]) ? $this->settings[$key] : null;
    }
}
