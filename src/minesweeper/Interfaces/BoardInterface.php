<?php

namespace Minesweeper\Interfaces;

interface BoardInterface
{
    public function getPlayerBoard(): array;
    public function getBombBoard(): array;
}
