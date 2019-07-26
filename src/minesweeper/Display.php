<?php

namespace Minesweeper;

use Minesweeper\Interfaces\DisplayInterface;
use Minesweeper\Interfaces\BoardInterface;

class Display implements DisplayInterface
{
    private $status;
    private $playerBoard;
    private $bombBoard;

    public function __construct(string $status, BoardInterface $board)
    {
        $this->status = $status;
        $this->playerBoard = $board->getPlayerBoard();
        $this->bombBoard = $board->getBombBoard();
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPlayerBoard(): array
    {
        return $this->playerBoard;
    }

    public function getBombBoard(): array
    {
        return $this->bombBoard;
    }
}
