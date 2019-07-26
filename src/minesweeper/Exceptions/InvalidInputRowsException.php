<?php
namespace Minesweeper\Exceptions;

class InvalidInputRowsException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Number of rows should be integer and greater than or equal to 2", 422);
    }
}
