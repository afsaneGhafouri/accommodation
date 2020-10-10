<?php

namespace Tests\Unit\Http\Controllers;
use PHPUnit\Framework\TestCase;

trait TraitTest
{
    public function concreteMethod()
    {
        return $this->abstractMethod();
    }

    public abstract function abstractMethod();
}

class TraitClassTest extends TestCase
{
    public function testConcreteMethod()
    {
        $mock = $this->getMockForTrait(TraitTest::class);
        $mock->method('abstractMethod')->willReturn(true);

        $this->assertTrue($mock->concreteMethod());
    }
}
