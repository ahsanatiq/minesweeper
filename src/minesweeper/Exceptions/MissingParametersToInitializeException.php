<?php
namespace Minesweeper\Exceptions;

class MissingParametersToInitializeException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Cannot initialize the game without rows or columns or bombs", 422);
    }
}
