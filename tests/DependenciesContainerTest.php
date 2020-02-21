<?php

namespace Spirling\DependenciesContainerTests;

use Exception;
use PHPUnit\Framework\TestCase;
use Spirling\DependenciesContainer\DependenciesContainer;
use Spirling\DependenciesContainerTests\Mocks\CycleDependencyClass;
use Spirling\DependenciesContainerTests\Mocks\FirstDependencyClass;
use Spirling\DependenciesContainerTests\Mocks\SecondDependencyClass;

class DependenciesContainerTest extends TestCase
{

    public function testCyclicDependencies()
    {
        $container = new DependenciesContainer();

        $this->expectException(Exception::class);

        $container->set(CycleDependencyClass::class, [FirstDependencyClass::class]);
        $container->set(FirstDependencyClass::class, [SecondDependencyClass::class]);
        $container->set(SecondDependencyClass::class, [CycleDependencyClass::class]);

        $container->init(CycleDependencyClass::class);
    }

}