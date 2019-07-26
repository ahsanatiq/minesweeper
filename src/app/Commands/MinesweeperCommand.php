<?php

namespace App\Commands;

use Minesweeper\Interfaces\GameInterface;
use Minesweeper\Interfaces\DisplayInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use League\CLImate\CLImate;

class MinesweeperCommand extends Command
{
    private $game;
    private $cli;

    public function __construct(GameInterface $game, CLImate $cli)
    {
        $this->game = $game;
        $this->cli = $cli;
        parent::__construct();
    }

    public function configure()
    {
        $this
        ->setName('minesweeper:play')
        ->setDescription('Start playing the game')
        ->setHelp('This command allows you to start the game and play')
        ->addOption(
            'rows',
            'r',
            InputOption::VALUE_OPTIONAL,
            'number of rows of the board',
            config()->get('app.defaultBoardRows')
        )
        ->addOption(
            'columns',
            'c',
            InputOption::VALUE_OPTIONAL,
            'number of columns of the board',
            config()->get('app.defaultBoardColumns')
        )
        ->addOption(
            'bombs',
            'b',
            InputOption::VALUE_OPTIONAL,
            'number of hidden bombs in the board',
            config()->get('app.defaultBoardBombs')
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->game->setRows((int) $input->getOption('rows'));
            $this->game->setColumns((int) $input->getOption('columns'));
            $this->game->setBombs((int) $input->getOption('bombs'));

            $display = $this->game->initialize();
            $this->print($display);
            while (true) {
                if ($display->getStatus() === $this->game::STATUS_GAME_OVER ||
                    $display->getStatus() === $this->game::STATUS_GAME_WON) {
                    $input = $this->cli->br()->input('Do you want to play again?');
                    $input->accept(['y', 'n'], true);
                    $response = $input->prompt();
                    if (strtolower($response) == 'n') {
                        break;
                    }
                    $display = $this->game->initialize();
                    $this->print($display);
                } else {
                    $input = $this->cli->br()->input('Please enter row & column (separated by space):');
                    $response = $input->prompt();
                    [$row, $column] = explode(' ', $response);
                    $row = filter_var($row, FILTER_VALIDATE_INT) !== false ? (int) $row : '';
                    $column = filter_var($column, FILTER_VALIDATE_INT) !== false ? (int) $column : '';
                    $display = $this->game->playMove($row, $column);
                    $this->print($display);
                }
            }
        } catch (\Exception $e) {
            logger()->info($e->getMessage());
            $this->cli->br()->bold()->backgroundRed()->white()->out('Error: '.$e->getMessage());
        }
    }

    private function print(DisplayInterface $display)
    {
        if ($display->getStatus() === $this->game::STATUS_GAME_OVER) {
            $board = $display->getBombBoard();
        } else {
            $board = $display->getPlayerBoard();
        }

        // insert index at start for columns
        $headerRow = [' '];
        foreach ($board[0] as $key => $cell) {
            $headerRow[] = '<bold><blue>'.$key.'</blue></bold>';
        }
        // insert index at start for rows
        foreach ($board as $key => $row) {
            array_unshift($row, '<bold><blue>'.$key.'</blue></bold>');
            $board[$key] = $row;
        }
        array_unshift($board, $headerRow);

        $this->cli->clear();
        $this->cli->br()->table($board);

        if ($display->getStatus() == $this->game::STATUS_WRONG_MOVE) {
            $this->cli->br()->red()->flank('Input not valid. Try Again.');
        } elseif ($display->getStatus() == $this->game::STATUS_GAME_OVER) {
            $this->cli->br()->red()->flank('Boom! Game Over', '!');
        } elseif ($display->getStatus() == $this->game::STATUS_GAME_WON) {
            $this->cli->br()->green()->flank('Hurry! You have won the game', '!');
        }
    }
}
