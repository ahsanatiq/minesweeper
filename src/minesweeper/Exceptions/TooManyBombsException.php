<?php
namespace Minesweeper\Exceptions;

class TooManyBombsException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Number of bombs should be less than or equal to multiplication of rows and columns", 422);
    }
}
