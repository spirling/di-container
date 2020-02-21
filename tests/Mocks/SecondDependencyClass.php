<?php

namespace Spirling\DependenciesContainerTests\Mocks;

class SecondDependencyClass
{

    private $dependencies = [];

    public function __construct(CycleDependencyClass $dependency)
    {
        $this->dependencies[] = $dependency;
    }

}