<?php

namespace Spirling\DependenciesContainerTests\Mocks;

class CycleDependencyClass
{

    private $dependencies = [];

    public function __construct(FirstDependencyClass $dependency)
    {
        $this->dependencies[] = $dependency;
    }

}