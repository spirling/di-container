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
     * @var array
     */
    private $stack = [];

    /**
     * DependenciesContainer constructor.
     *
     * @param array $dependencies
     *
     * @throws Exception
     */
    public function __construct($dependencies = [])
    {
        foreach ($dependencies as $className => $childDependencies) {
            $this->set($className, $dependencies);
        }
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
        return $this->dependencies[$className] = new Dependency($this, $className, $dependencies);
    }

    /**
     * @param string $className
     *
     * @return object
     * @throws Exception
     */
    public function get($className)
    {
        $dependency = null;
        $stackKey = array_search($className, $this->stack, true);
        if ($stackKey !== false) {
            $stackCall = implode(PHP_EOL . '" -> "', array_slice($this->stack, $stackKey));
            throw new Exception(sprintf('Cyclic dependencies detected for class "%s": "%s"', $className, $stackCall));
        } else {
            array_push($this->stack, $className);
            if (array_key_exists($className, $this->dependencies)) {
                $dependency = $this->dependencies[$className]->get();
            } else {
                array_pop($this->stack);
                throw new Exception('Dependency "' . $className . '" is not set. Could not get dependency!');
            }
            array_pop($this->stack);
        }
        return $dependency;
    }

    /**
     * @param string $className name of dependency
     *
     * @return bool
     */
    public function has($className)
    {
        return array_key_exists($className, $this->dependencies);
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