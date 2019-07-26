<?php
namespace Minesweeper\Exceptions;

class InvalidInputColumnsException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Number of columns should be integer and greater than or equal to 2", 422);
    }
}
