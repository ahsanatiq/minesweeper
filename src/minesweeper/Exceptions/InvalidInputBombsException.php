<?php
namespace Minesweeper\Exceptions;

class InvalidInputBombsException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Number of bombs should be integer and greater than 0", 422);
    }
}
