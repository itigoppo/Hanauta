<?php

namespace Hanauta;


class Application
{
    protected $config_dir;

    /**
     * Application constructor.
     *
     * @param string $config_directory config path
     */
    public function __construct($config_directory)
    {
        $this->config_dir = $config_directory;
    }
}
