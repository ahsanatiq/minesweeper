<?php

namespace Minesweeper;

use Minesweeper\Board;
use Minesweeper\Interfaces\GameInterface;
use Minesweeper\Interfaces\DisplayInterface;
use Minesweeper\Exceptions\TooManyBombsException;
use Minesweeper\Exceptions\InvalidInputRowsException;
use Minesweeper\Exceptions\InvalidInputBombsException;
use Minesweeper\Exceptions\MissingRowsColumnsException;
use Minesweeper\Exceptions\InvalidInputColumnsException;
use Minesweeper\Exceptions\MissingParametersToInitializeException;

class Game implements GameInterface
{
    const STATUS_GAME_OVER = 'Over';
    const STATUS_GAME_WON = 'Won';
    const STATUS_GAME_PLAY = 'Play';
    const STATUS_WRONG_MOVE = 'Wrong';

    const MIN_ROWS = 2;
    const MIN_COLUMNS = 2;
    const MIN_BOMBS = 1;

    private $rows;
    private $columns;
    private $bombs;
    private $board;

    public function setRows($rows): void
    {
        if (!is_integer($rows) || $rows < self::MIN_ROWS) {
            throw new InvalidInputRowsException;
        }

        $this->rows = $rows;
    }

    public function setColumns($columns): void
    {
        if (!is_integer($columns) || $columns < self::MIN_COLUMNS) {
            throw new InvalidInputColumnsException;
        }

        $this->columns = $columns;
    }

    public function setBombs($bombs): void
    {
        if (!is_integer($bombs) || $bombs < self::MIN_BOMBS) {
            throw new InvalidInputBombsException;
        }
        if (empty($this->rows) || empty($this->columns)) {
            throw new MissingRowsColumnsException;
        }
        if ($bombs >= $this->rows*$this->columns) {
            throw new TooManyBombsException;
        }

        $this->bombs = $bombs;
    }

    public function initialize(): DisplayInterface
    {
        if (empty($this->rows) || empty($this->columns) || empty($this->bombs)) {
            throw new MissingParametersToInitializeException;
        }

        $this->board = new Board($this->rows, $this->columns, $this->bombs);
        return new Display(self::STATUS_GAME_PLAY, $this->board);
    }

    public function playMove($row, $column): DisplayInterface
    {
        if (!is_integer($row) || $row >= $this->rows || $row < 0 ||
             !is_integer($column) || $column >= $this->columns || $column < 0) {
            return new Display(self::STATUS_WRONG_MOVE, $this->board);
        }

        $this->board->flip($row, $column);
        $status = self::STATUS_GAME_PLAY;
        if ($this->board->getPlayerBoard()[$row][$column] === $this->board::BOMB_CELL) {
            $status = self::STATUS_GAME_OVER;
        } elseif (!$this->board->hasNonBombEmptySpaces()) {
            $status = self::STATUS_GAME_WON;
        }
        return new Display($status, $this->board);
    }
}
