<?php

header('Content-Type: application/json');
require __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$postData = new \Validators\GameValidator($_POST);

$board = new \Classes\Board();
$board->setWidth($postData->boardWidth);
$board->setHeight($postData->boardHeight);

$game = new \Classes\Game();
$game->setBoard($board);
$game->setRandomCount($postData->randomCells);
$game->setPreviousBoardCells($postData->previousBoardCells);
$game->setRandomPositions();

$game->drawGame();

exit(json_encode($game));
