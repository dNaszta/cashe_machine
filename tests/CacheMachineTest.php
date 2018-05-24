<?php

use Naszta\CacheMachine;
use \PHPUnit\Framework\TestCase;

final class CacheMachineTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_created()
    {
        $cacheMachine = new CacheMachine();
        $this->assertInstanceOf(CacheMachine::class, $cacheMachine);
    }
}