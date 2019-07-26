<?php

namespace Minesweeper\Interfaces;

use Minesweeper\Interfaces\DisplayInterface;

interface GameInterface
{
    public function setRows(int $number): void;
    public function setColumns(int $number): void;
    public function setBombs(int $number): void;
    public function initialize(): DisplayInterface;
    public function playMove(int $row, int $column): DisplayInterface;
}
