<?php

namespace Main;

use Slim\App;
use Interop\Container\ContainerInterface;
use Propel\Runtime\Propel;
use Main\Dependency;

class Main
{
    private $slim, $route, $configFolder;

    public function __construct($configFolder)
    {
        $this->configFolder = $configFolder;
    }

    public function run()
    {
        global $slim;

        // create slim application
        $this->slim = $slim = new App(include($this->configFolder . '/slim.php'));

        // init propel
        // Propel::init("../generated-conf/config.php");

        // injection container dependency
        $this->injectDependency();

        // load and run route
        $this->route = new Route($this->slim);
        $this->route->run();

        // run slim application
        $this->slim->run();
    }

    public function injectDependency()
    {
        $container = $this->slim->getContainer();

        // Register component on container
        // inject config
        $container["config_folder"] = $this->configFolder;
        $container["config"] = function (ContainerInterface $container) {
            $files = scandir($container["config_folder"]);
            $configs = [];
            foreach ($files as $item) {
                $path = $container["config_folder"] . "/" . $item;
                if (is_file($path)) {
                    $name = basename($path, ".php");
                    $configs[$name] = include($path);
                }
            }
            return $configs;
        };

        $dependency = new Dependency($this->slim);
        $dependency->run();
    }

    public function addMiddleware()
    {
        // $this->slim->add(new AuthMiddleware());
    }
}
