<?php

return [
    'name' => 'Minesweeper',
    'env' => getenv('APP_ENV') ?: 'production', // dev, testing, production
    'defaultBoardRows' => getenv('APP_BOARD_ROWS') ?: 25,
    'defaultBoardColumns' => getenv('APP_BOARD_COLUMNS') ?: 30,
    'defaultBoardBombs' => getenv('APP_BOARD_BOMBS') ?: 25,
];
