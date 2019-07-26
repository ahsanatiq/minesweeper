<?php

namespace Minesweeper;

use Minesweeper\Exceptions\MissingPlayerBoardException;
use Minesweeper\Interfaces\BoardInterface;

class Board implements BoardInterface
{
    const EMPTY_CELL = '_';
    const BOMB_CELL = 'X';

    private $playerBoard;
    private $bombBoard;
    private $rows;
    private $columns;
    private $bombs;
    private $numberOfEmptySpaces;

    public function __construct(int $rows, int $columns, int $bombs)
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->bombs = $bombs;

        $this->numberOfEmptySpaces = $this->rows * $this->columns;
        $this->playerBoard = $this->generatePlayerBoard();
        $this->bombBoard = $this->generateBombBoard();
    }

    public function flip(int $row, int $column)
    {
        if ($this->playerBoard[$row][$column] !== self::EMPTY_CELL) {
            return;
        }
        if ($this->bombBoard[$row][$column] === self::BOMB_CELL) {
            $this->playerBoard[$row][$column] = self::BOMB_CELL;
        } else {
            $numberOfNeighborBombs = $this->getNumberOfNeighborBombs($row, $column);
            $this->bombBoard[$row][$column] = $numberOfNeighborBombs;
            $this->playerBoard[$row][$column] = $numberOfNeighborBombs;
        }
        $this->numberOfEmptySpaces--;
    }

    public function hasNonBombEmptySpaces()
    {
        return $this->numberOfEmptySpaces !== $this->bombs;
    }

    public function getPlayerBoard(): array
    {
        return $this->playerBoard;
    }

    public function getBombBoard(): array
    {
        return $this->bombBoard;
    }

    private function getNumberOfNeighborBombs(int $row, int $column)
    {
        $neighborOffsets = [
            [-1, -1],
            [-1, 0],
            [-1, 1],
            [0, -1],
            [0, 1],
            [1, -1],
            [1, 0],
            [1, 1]
        ];

        $numberOfBombs = 0;
        foreach ($neighborOffsets as $offset) {
            $neighborRowIndex = $row + $offset[0];
            $neighborColumnIndex = $column + $offset[1];
            if ($neighborRowIndex >= 0 && $neighborRowIndex < $this->rows &&
                $neighborColumnIndex >= 0 && $neighborColumnIndex < $this->columns) {
                if ($this->bombBoard[$neighborRowIndex][$neighborColumnIndex] === self::BOMB_CELL) {
                    $numberOfBombs++;
                }
            }
        }
        return $numberOfBombs;
    }

    private function generatePlayerBoard()
    {
        $board = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $row = [];
            for ($j = 0; $j < $this->columns; $j++) {
                $row[] = self::EMPTY_CELL;
            }
            $board[] = $row;
        }
        return $board;
    }

    private function generateBombBoard()
    {
        if (empty($this->playerBoard)) {
            throw new MissingPlayerBoardException;
        }

        $bombBoard = $this->playerBoard;

        $numberOfBombsPlaced = 0;
        while ($numberOfBombsPlaced < $this->bombs) {
            $randomRowIndex = rand(0, ($this->rows - 1));
            $randomColumnIndex = rand(0, ($this->columns - 1));
            if ($bombBoard[$randomRowIndex][$randomColumnIndex] !== self::BOMB_CELL) {
                $bombBoard[$randomRowIndex][$randomColumnIndex] = self::BOMB_CELL;
                $numberOfBombsPlaced++;
            }
        }

        return $bombBoard;
    }
}
