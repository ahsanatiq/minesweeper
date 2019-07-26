<?php

namespace Minesweeper\Interfaces;

interface DisplayInterface
{
    public function getStatus(): string;
    public function getPlayerBoard(): array;
    public function getBombBoard(): array;
}
