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

    /**
     * @test
     */
    public function it_can_set_entry()
    {
        $cacheMachine = new CacheMachine(10);
        $this->assertEquals("10.00", $cacheMachine->getEntry());
    }

    /**
     * @test
     */
    public function it_can_deliver_30()
    {
        $cacheMachine = new CacheMachine("30.00");
        $cacheMachine->setNotes();
        $result = $cacheMachine->withdraw();
        $this->assertTrue(is_array($result));
        $this->assertEquals(["20.00", "10.00"], $result);
    }

    /**
     * @test
     */
    public function it_can_deliver_80()
    {
        $cacheMachine = new CacheMachine(80.00);
        $cacheMachine->setNotes();
        $result = $cacheMachine->withdraw();
        $this->assertTrue(is_array($result));
        $this->assertEquals([50.00, 20.00, 10.00], $result);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_cannot_deliver_negative_number()
    {
        $cacheMachine = new CacheMachine(-130.00);
    }

    /**
     * @test
     * @expectedException \Naszta\Exceptions\NoteUnavailableException
     */
    public function it_cannot_deliver_with_unavailable_note()
    {
        $cacheMachine = new CacheMachine(125.00);
        $cacheMachine->setNotes();
    }

    /**
     * @test
     */
    public function it_can_deliver_empty_set()
    {
        $cacheMachine = new CacheMachine();
        $cacheMachine->setNotes();
        $result = $cacheMachine->withdraw();
        $this->assertEquals(["Empty Set"], $result);
    }

    /**
     * @test
     */
    public function it_can_deliver_with_any_notes()
    {
        $cacheMachine = new CacheMachine(10);
        $cacheMachine->setNotes(9,1);
        $result = $cacheMachine->withdraw();
        $this->assertEquals(["9.00","1.00"], $result);
    }
}