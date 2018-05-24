<?php

namespace Naszta;


use Naszta\Exceptions\NoteUnavailableException;

class CacheMachine
{
    const AMOUNT_TO_CENT = 100;
    const FLOAT_TO_INT_PRECISION = 2;
    const EMPTY_SET_VALUE = "Empty Set";
    const DEFAULT_NOTES = [100.0, 50.0, 20.0, 10.0];

    /** @var array */
    protected $notes;

    /** @var int */
    protected $entry;

    /**
     * CacheMachine constructor.
     * @param float|null $entry
     * @throws \InvalidArgumentException
     */
    public function __construct(float $entry = null)
    {
        $this->positiveNumberValidation($entry);
        $this->entry = $this->convertAmountToCents($entry);
    }

    /**
     * @param float ...$notes
     * @throws NoteUnavailableException
     * @throws \InvalidArgumentException
     */
    public function setNotes(float ...$notes) : void
    {
        if($notes == null) {
            $notes = self::DEFAULT_NOTES;
        }

        foreach ($notes as $note) {
            $this->positiveNumberValidation($note);
        }

        rsort($notes, SORT_NUMERIC);
        $this->notes = $notes;
        $this->noteAvailableValidation($this->entry);
    }

    /**
     * @return string
     */
    public function getEntry(): string
    {
        return $this->convertCentToAmount($this->entry);
    }

    /**
     * @return array
     */
    public function withdraw(): array
    {
        $set = [];
        $tempAmount = $this->entry;
        foreach ($this->notes as $note){
            $noteInCent = $this->convertAmountToCents($note);
            if($tempAmount >= $noteInCent) {
                $set[] = $this->convertCentToAmount($noteInCent);
                $times = floor($tempAmount / $noteInCent);
                $decrease = $times * $noteInCent;
                $tempAmount = $tempAmount - $decrease;
            }
        }

        if(empty($set)) {
            $set[] = self::EMPTY_SET_VALUE;
        }

        return $set;
    }

    /**
     * @param float $number
     */
    protected function positiveNumberValidation(float $number = null) : void
    {
        if($number < 0)
            throw new \InvalidArgumentException();
    }

    /**
     * @param int $entry
     * @throws NoteUnavailableException
     */
    protected function noteAvailableValidation(int $entry) : void
    {
        $smallestNote = $this->convertAmountToCents(end($this->notes));
        if($entry % $smallestNote != 0) {
            throw new NoteUnavailableException();
        }
    }

    /**
     * @param float $amount
     * @return int
     */
    protected function convertAmountToCents(float $amount = null) : int
    {
        return round($amount,self::FLOAT_TO_INT_PRECISION) * self::AMOUNT_TO_CENT;
    }

    /**
     * @param int $cent
     * @return string
     */
    protected function convertCentToAmount(int $cent) : string
    {
        return number_format(
            ($cent / self::AMOUNT_TO_CENT),
            self::FLOAT_TO_INT_PRECISION,
            '.',
            '');
    }
}