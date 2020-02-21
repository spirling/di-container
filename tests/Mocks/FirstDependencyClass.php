<?php

namespace Spirling\DependenciesContainerTests\Mocks;

class FirstDependencyClass
{

    private $dependencies = [];

    public function __construct(SecondDependencyClass $dependency)
    {
        $this->dependencies[] = $dependency;
    }

}