<?php

return [
    'file' => getenv('APP_LOG_FILE') ?: __DIR__.'/../logs/app.log',
    'days' => getenv('APP_LOG_DAYS') ?: '7',
    'level' => getenv('APP_LOG_LEVEL') ?: 'DEBUG',
];
