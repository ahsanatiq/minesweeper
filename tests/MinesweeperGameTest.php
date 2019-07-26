<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Minesweeper\Exceptions\TooManyBombsException;
use Minesweeper\Exceptions\InvalidInputRowsException;
use Minesweeper\Exceptions\InvalidInputBombsException;
use Minesweeper\Exceptions\MissingRowsColumnsException;
use Minesweeper\Exceptions\InvalidInputColumnsException;
use Minesweeper\Exceptions\MissingParametersToInitializeException;
use Minesweeper\Board;

class MinesweeperGameTest extends TestCase
{
    private $game;

    protected function setUp(): void
    {
        $this->game = new \Minesweeper\Game();
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotOkayIfLessThanRowsColumnsCells()
    {
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs(24);
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeTooManyBombs()
    {
        $this->expectException(TooManyBombsException::class);
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs(25);
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeInsertedBeforeRowsColumns()
    {
        $this->expectException(MissingRowsColumnsException::class);
        $this->game->setBombs(4);
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeInsertedBeforeRows()
    {
        $this->expectException(MissingRowsColumnsException::class);
        $this->game->setColumns(5);
        $this->game->setBombs(4);
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeInsertedBeforeColumns()
    {
        $this->expectException(MissingRowsColumnsException::class);
        $this->game->setRows(5);
        $this->game->setBombs(4);
    }

    /**
     * @test
     */
    public function inputBombs_shouldBeInteger()
    {
        $this->expectException(InvalidInputBombsException::class);
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs('abc');
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeEmpty()
    {
        $this->expectException(InvalidInputBombsException::class);
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs('');
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeZero()
    {
        $this->expectException(InvalidInputBombsException::class);
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs(0);
    }

    /**
     * @test
     */
    public function inputBombs_shouldNotBeLessThanZero()
    {
        $this->expectException(InvalidInputBombsException::class);
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs(-1);
    }


    /**
     * @test
     */
    public function inputBombs_shouldBeOkayIfgreaterThanEqualTo2()
    {
        $this->game->setRows(5);
        $this->game->setColumns(5);
        $this->game->setBombs(2);
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function inputColumns_shouldBeInteger()
    {
        $this->expectException(InvalidInputColumnsException::class);
        $this->game->setColumns('abc');
    }

    /**
     * @test
     */
    public function inputColumns_shouldNotBeEmpty()
    {
        $this->expectException(InvalidInputColumnsException::class);
        $this->game->setColumns('');
    }

    /**
     * @test
     */
    public function inputColumns_shouldNotBeZero()
    {
        $this->expectException(InvalidInputColumnsException::class);
        $this->game->setColumns(0);
    }

    /**
     * @test
     */
    public function inputColumns_shouldNotBeLessThanZero()
    {
        $this->expectException(InvalidInputColumnsException::class);
        $this->game->setColumns(-1);
    }

    /**
     * @test
     */
    public function inputColumns_shouldNotBeLessThan2()
    {
        $this->expectException(InvalidInputColumnsException::class);
        $this->game->setColumns(1);
    }

    /**
     * @test
     */
    public function inputColumns_shouldBeOkayIfgreaterThanEqualTo2()
    {
        $this->game->setColumns(2);
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function inputRows_shouldBeInteger()
    {
        $this->expectException(InvalidInputRowsException::class);
        $this->game->setRows('abc');
    }

    /**
     * @test
     */
    public function inputRows_shouldNotBeEmpty()
    {
        $this->expectException(InvalidInputRowsException::class);
        $this->game->setRows('');
    }

    /**
     * @test
     */
    public function inputRows_shouldNotBeZero()
    {
        $this->expectException(InvalidInputRowsException::class);
        $this->game->setRows(0);
    }

    /**
     * @test
     */
    public function inputRows_shouldNotBeLessThanZero()
    {
        $this->expectException(InvalidInputRowsException::class);
        $this->game->setRows(-1);
    }

    /**
     * @test
     */
    public function inputRows_shouldNotBeLessThan2()
    {
        $this->expectException(InvalidInputRowsException::class);
        $this->game->setRows(1);
    }

    /**
     * @test
     */
    public function inputRows_shouldBeOkayIfgreaterThanEqualTo2()
    {
        $this->game->setRows(2);
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function initializeGame_shouldNotInitalizeIfRowsMissing()
    {
        $this->expectException(MissingParametersToInitializeException::class);
        $this->game->initialize();
    }

    /**
     * @test
     */
    public function initializeGame_shouldBeOkayIfRowsColumnsBombsAreValid()
    {
        $this->game->setRows($rows = 25);
        $this->game->setColumns($columns = 30);
        $this->game->setBombs($bombs = 25);
        $display = $this->game->initialize();

        $this->assertNotEmpty($display);
        $this->assertSame($display->getStatus(), $this->game::STATUS_GAME_PLAY);
        $this->assertNotEmpty($board = $display->getPlayerBoard());
        // check the player board
        $numberOfRowsOfBoard = count($board);
        $this->assertSame($numberOfRowsOfBoard, $rows);
        foreach ($board as $rowOfBoard) {
            $numberOfColumnsOfRowOfBoard = count($rowOfBoard);
            $this->assertSame($numberOfColumnsOfRowOfBoard, $columns);
            // check each cell is empty '_'
            foreach ($rowOfBoard as $cell) {
                $this->assertSame($cell, Board::EMPTY_CELL);
            }
        }
        // check the bomb board for number of bombs
        $board = $display->getBombBoard();
        $numberOfBombsInBoard = 0;
        $numberOfRowsOfBoard = count($board);
        $this->assertSame($numberOfRowsOfBoard, $rows);
        foreach ($board as $rowOfBoard) {
            $numberOfColumnsOfRowOfBoard = count($rowOfBoard);
            $this->assertSame($numberOfColumnsOfRowOfBoard, $columns);
            // check for bomb cells
            foreach ($rowOfBoard as $cell) {
                if ($cell == Board::BOMB_CELL) {
                    $numberOfBombsInBoard++;
                }
            }
        }
        $this->assertSame($numberOfBombsInBoard, $bombs);
    }

    /**
     * @test
     */
    public function playGame_shouldBeWrongMoveIfRowColumnNotValid()
    {
        $this->game->setRows(25);
        $this->game->setColumns(30);
        $this->game->setBombs(25);
        $this->game->initialize();

        $display = $this->game->playMove(0, -1);
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());

        $display = $this->game->playMove(-1, 0);
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());

        $display = $this->game->playMove(30, 10);
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());

        $display = $this->game->playMove(10, 30);
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());

        $display = $this->game->playMove('10', 0);
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());

        $display = $this->game->playMove(0, '10');
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());

        $display = $this->game->playMove(0.5, 10);
        $this->assertSame($this->game::STATUS_WRONG_MOVE, $display->getStatus());
    }

    /**
     * @test
     */
    public function playGame_shouldBeGameOverIfStepOverTheBomb()
    {
        $this->game->setRows(25);
        $this->game->setColumns(30);
        $this->game->setBombs(25);
        $display = $this->game->initialize();

        // lets find the bomb and step over it
        $bombBoard = $display->getBombBoard();
        foreach ($bombBoard as $rowKey => $rowOfBombBoard) {
            foreach ($rowOfBombBoard as $columnKey => $cell) {
                if ($cell === Board::BOMB_CELL) {
                    break(2);
                }
            }
        }
        $display = $this->game->playMove($rowKey, $columnKey);

        $this->assertSame($display->getStatus(), $this->game::STATUS_GAME_OVER);
        $this->assertSame(Board::BOMB_CELL, $display->getPlayerBoard()[$rowKey][$columnKey]);
    }

    /**
     * @test
     */
    public function playGame_shouldHaveWonIfNotStepOverAllTheBombs()
    {
        $this->game->setRows($numberOfRows = 25);
        $this->game->setColumns($numberOfColumns = 30);
        $this->game->setBombs($numberOfBombs = 25);
        $display = $this->game->initialize();

        // lets find all the bombs
        $bombBoard = $display->getBombBoard();
        $bombLocations = [];
        foreach ($bombBoard as $rowKey => $rowOfBombBoard) {
            foreach ($rowOfBombBoard as $columnKey => $cell) {
                if ($cell === Board::BOMB_CELL) {
                    $bombLocations[$rowKey][$columnKey] = 1;
                }
            }
        }
        // lets step over all the empty cells except bombs
        $board = $display->getPlayerBoard();
        $bombsFound = 0;
        $totalCells = $numberOfRows * $numberOfColumns;
        foreach ($board as $rowKey => $rowOfBoard) {
            foreach ($rowOfBoard as $columnKey => $cell) {
                if (isset($bombLocations[$rowKey][$columnKey])) {
                    $bombsFound++;
                    $totalCells--;
                    continue;
                }

                $expectedStatus = $this->game::STATUS_GAME_PLAY;
                if ($bombsFound + ($totalCells-1) === $numberOfBombs) {
                    $expectedStatus = $this->game::STATUS_GAME_WON;
                }

                $display = $this->game->playMove($rowKey, $columnKey);
                $this->assertSame($expectedStatus, $display->getStatus());
                $this->assertNotSame(Board::BOMB_CELL, $display->getPlayerBoard()[$rowKey][$columnKey]);
                $this->assertNotSame(Board::EMPTY_CELL, $display->getPlayerBoard()[$rowKey][$columnKey]);
                $totalCells--;
            }
        }
    }
}
