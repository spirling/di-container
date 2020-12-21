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
    protected $container;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var array|null
     */
    protected $dependencies;

    /**
     * @var object
     */
    protected $object;

    /**
     * Dependency constructor.
     *
     * @param DependenciesContainer $container
     * @param string $className
     * @param array $dependencies
     *
     * @throws
     */
    public function __construct(DependenciesContainer $container, $className, $dependencies = null)
    {
        $this->container = $container;
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
                        $dependencies[] = $this->container->get($dependency);
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