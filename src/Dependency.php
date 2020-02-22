<?php

namespace Spirling\DependenciesContainer;

use Exception;

/**
 * Class Dependency
 *
 * @package Premmerce\InventoryExtension\Containers\DependencyInjection
 */
class Dependency
{

    /**
     * @var DependenciesContainer
     */
    private static $container;

    /**
     * @var string
     */
    private $className;

    /**
     * @var array|null
     */
    private $dependencies;

    /**
     * @var object
     */
    private $object;

    /**
     * @param DependenciesContainer $container
     */
    public static function initialize(DependenciesContainer $container)
    {
        static $init = true;
        if ($init) {

            self::$container = $container;

            $init = false;
        }
    }

    /**
     * Dependency constructor.
     *
     * @param string $className
     * @param array $dependencies
     *
     * @throws
     */
    public function __construct($className, $dependencies = null)
    {
        if (!class_exists($className)) {
            throw new Exception('Class "' . $className . '" not found. Dependency could not be initialized!');
        }

        $this->className = $className;
        $this->dependencies = $dependencies;
    }

    /**
     * @return object
     * @throws Exception
     */
    public function get()
    {
        if (is_null($this->object)) {
            $className = $this->className;
            if (!is_null($this->dependencies)) {
                $dependencies = [];
                foreach ($this->dependencies as $dependency) {
                    if (is_string($dependency) && class_exists($dependency)) {
                        $dependencies[] = self::$container->get($dependency);
                    } else {
                        $dependencies[] = $dependency;
                    }
                }

                $this->object = new $className(...$dependencies);
            } else {
                $this->object = new $className();
            }
        }
        return $this->object;
    }

    /**
     * @throws Exception
     */
    public function init()
    {
        $this->get();
    }

}