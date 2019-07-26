<?php
namespace Minesweeper\Exceptions;

class MissingRowsColumnsException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Rows or columns should be available when setting number of bombs", 422);
    }
}
