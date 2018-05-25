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
        $cashMachine = new CashMachine();
        $this->assertInstanceOf(CashMachine::class, $cashMachine);
    }

    /**
     * @test
     */
    public function it_can_set_entry()
    {
        $cashMachine = new CashMachine(10);
        $this->assertEquals("10.00", $cashMachine->getEntry());
    }

    /**
     * @test
     */
    public function it_can_deliver_30()
    {
        $cashMachine = new CashMachine("30.00");
        $result = $cashMachine->withdraw();
        $this->assertTrue(is_array($result));
        $this->assertEquals(["20.00", "10.00"], $result);
    }

    /**
     * @test
     */
    public function it_can_deliver_80()
    {
        $cashMachine = new CashMachine(80.00);
        $cashMachine->setNotes();
        $result = $cashMachine->withdraw();
        $this->assertTrue(is_array($result));
        $this->assertEquals([50.00, 20.00, 10.00], $result);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_cannot_deliver_negative_number()
    {
        $cashMachine = new CashMachine(-130.00);
    }

    /**
     * @test
     * @expectedException \Naszta\Exceptions\NoteUnavailableException
     */
    public function it_cannot_deliver_with_unavailable_note()
    {
        $cashMachine = new CashMachine(125.00);
        $cashMachine->setNotes();
    }

    /**
     * @test
     */
    public function it_can_deliver_empty_set()
    {
        $cashMachine = new CashMachine();
        $result = $cashMachine->setNotes()->withdraw();
        $this->assertEquals(["Empty Set"], $result);
    }

    /**
     * @test
     */
    public function it_can_deliver_with_any_notes()
    {
        $cashMachine = new CashMachine(10);
        $result = $cashMachine->setNotes(9, 1)
            ->withdraw();
        $this->assertEquals(["9.00", "1.00"], $result);
    }
}