<?php

namespace DocumentFilter;

class Configuration
{
    private $settings;

    public function __construct($configFile)
    {
        $this->settings = require $configFile;
    }

    public function get($key)
    {
        return $key && isset($this->settings[$key]) ? $this->settings[$key] : null;
    }
}