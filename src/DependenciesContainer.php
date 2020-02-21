<?php

namespace Spirling\DependenciesContainer;

use Exception;

/**
 * Class DependenciesContainer
 *
 * @package Premmerce\InventoryExtension\Containers\DependencyInjection
 */
class DependenciesContainer
{

    /**
     * @var Dependency[]
     */
    private $dependencies;

    /**
     * DependenciesContainer constructor.
     */
    public function __construct()
    {
        Dependency::initialize($this);
    }

    /**
     * @param string $className
     * @param array $dependencies
     *
     * @throws Exception
     * @return Dependency
     */
    public function set($className, $dependencies = null)
    {
        return $this->dependencies[$className] = new Dependency($className, $dependencies);
    }

    /**
     * @param string $className
     *
     * @return object
     * @throws Exception
     */
    public function get($className)
    {
        if (array_key_exists($className, $this->dependencies)) {
            return $this->dependencies[$className]->get();
        } else {
            throw new Exception('Dependency "' . $className . '" is not set. Could not get dependency!');
        }
    }

    /**
     * @param string $className
     *
     * @throws Exception
     */
    public function init($className)
    {
        if (array_key_exists($className, $this->dependencies)) {
            $this->dependencies[$className]->init();
        } else {
            throw new Exception('Dependency "' . $className . '" is not set. Could not init dependency!');
        }
    }

}