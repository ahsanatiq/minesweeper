<?php
namespace Minesweeper\Exceptions;

class MissingPlayerBoardException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Player board should be created before creating bomb board", 422);
    }
}
