<?php

namespace Naszta\Exceptions;


class NoteUnavailableException extends \Exception
{
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}