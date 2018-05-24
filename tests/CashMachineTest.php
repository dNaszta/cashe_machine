<?php

use Naszta\CashMachine;
use \PHPUnit\Framework\TestCase;

final class CashMachineTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_created()
    {
        $CashMachine = new CashMachine();
        $this->assertInstanceOf(CashMachine::class, $CashMachine);
    }

    /**
     * @test
     */
    public function it_can_set_entry()
    {
        $CashMachine = new CashMachine(10);
        $this->assertEquals("10.00", $CashMachine->getEntry());
    }

    /**
     * @test
     */
    public function it_can_deliver_30()
    {
        $CashMachine = new CashMachine("30.00");
        $CashMachine->setNotes();
        $result = $CashMachine->withdraw();
        $this->assertTrue(is_array($result));
        $this->assertEquals(["20.00", "10.00"], $result);
    }

    /**
     * @test
     */
    public function it_can_deliver_80()
    {
        $CashMachine = new CashMachine(80.00);
        $CashMachine->setNotes();
        $result = $CashMachine->withdraw();
        $this->assertTrue(is_array($result));
        $this->assertEquals([50.00, 20.00, 10.00], $result);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_cannot_deliver_negative_number()
    {
        $CashMachine = new CashMachine(-130.00);
    }

    /**
     * @test
     * @expectedException \Naszta\Exceptions\NoteUnavailableException
     */
    public function it_cannot_deliver_with_unavailable_note()
    {
        $CashMachine = new CashMachine(125.00);
        $CashMachine->setNotes();
    }

    /**
     * @test
     */
    public function it_can_deliver_empty_set()
    {
        $CashMachine = new CashMachine();
        $CashMachine->setNotes();
        $result = $CashMachine->withdraw();
        $this->assertEquals(["Empty Set"], $result);
    }

    /**
     * @test
     */
    public function it_can_deliver_with_any_notes()
    {
        $CashMachine = new CashMachine(10);
        $CashMachine->setNotes(9, 1);
        $result = $CashMachine->withdraw();
        $this->assertEquals(["9.00", "1.00"], $result);
    }
}